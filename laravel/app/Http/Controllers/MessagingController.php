<?php

namespace App\Http\Controllers;

use App\Jobs\SendCampaignMessage;
use App\Models\Client;
use App\Models\Message;
use App\Models\MessageRecipient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessagingController extends Controller
{
    /**
     * Show the messaging page.
     */
    public function index(): View
    {
        $clients = Client::query()
            ->select(['id', 'company_name', 'contact_name', 'email', 'phone', 'status'])
            ->orderBy('company_name')
            ->get();

        $stats = [
            'total'      => $clients->count(),
            'withEmail'  => $clients->whereNotNull('email')->where('email', '!=', '')->count(),
            'withPhone'  => $clients->whereNotNull('phone')->where('phone', '!=', '')->count(),
            'active'     => $clients->where('status', Client::STATUS_ACTIVE)->count(),
        ];

        return view('content.messaging.index', compact('clients', 'stats'));
    }

    /**
     * List previously sent messages (campaign history).
     */
    public function history(Request $request): View
    {
        $messages = Message::query()
            ->with('sender:id,name')
            ->latest()
            ->get();

        $messageRows = $messages->map(fn(Message $m) => [
            'id'               => $m->id,
            'message_key'      => $m->message_key,
            'title'            => $m->title,
            'body'             => $m->body,
            'channels'         => $m->channels ?? [],
            'sent_by'          => $m->sender?->name ?? 'Système',
            'recipients_count' => (int) $m->recipients_count,
            'delivered_count'  => (int) $m->delivered_count,
            'failed_count'     => (int) $m->failed_count,
            'status'           => $m->status,
            'created_at'       => optional($m->created_at)->toIso8601String(),
        ])->values();

        $stats = [
            'total'     => $messages->count(),
            'sent'      => $messages->where('status', Message::STATUS_SENT)->count(),
            'partial'   => $messages->where('status', Message::STATUS_PARTIAL)->count(),
            'failed'    => $messages->where('status', Message::STATUS_FAILED)->count(),
            'delivered' => (int) $messages->sum('delivered_count'),
        ];

        // ── Channel usage breakdown (messages using each channel) ──
        $channelData = ['push' => 0, 'mail' => 0, 'whatsapp' => 0];
        foreach ($messages as $m) {
            foreach (($m->channels ?? []) as $ch) {
                if (array_key_exists($ch, $channelData)) {
                    $channelData[$ch]++;
                }
            }
        }

        // ── Status distribution ──
        $statusData = [
            'sent'    => $stats['sent'],
            'partial' => $stats['partial'],
            'failed'  => $stats['failed'],
            'queued'  => $messages->where('status', Message::STATUS_QUEUED)->count(),
        ];

        // ── 14-day activity trend (delivered vs failed per day) ──
        $trendLabels    = [];
        $trendDelivered = [];
        $trendFailed    = [];
        $byDay = $messages->groupBy(fn(Message $m) => optional($m->created_at)->format('Y-m-d'));
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $key = $day->format('Y-m-d');
            $dayMessages = $byDay->get($key, collect());
            $trendLabels[]    = $day->format('d/m');
            $trendDelivered[] = (int) $dayMessages->sum('delivered_count');
            $trendFailed[]    = (int) $dayMessages->sum('failed_count');
        }

        $charts = [
            'channels'       => $channelData,
            'status'         => $statusData,
            'trendLabels'    => $trendLabels,
            'trendDelivered' => $trendDelivered,
            'trendFailed'    => $trendFailed,
        ];

        return view('content.messaging.history', compact('messageRows', 'stats', 'charts'));
    }

    /**
     * Return the full detail of a single message (campaign) with its recipients.
     */
    public function show(Message $message): JsonResponse
    {
        $message->load(['sender:id,name']);

        $recipients = $message->recipients()
            ->with('client:id,company_name,contact_name,email,phone')
            ->get()
            ->map(fn(MessageRecipient $r) => [
                'id'      => $r->id,
                'name'    => $r->client?->company_name ?? $r->client?->contact_name ?? '—',
                'contact' => $r->channel === 'mail'
                    ? ($r->client?->email ?? '—')
                    : ($r->client?->phone ?? '—'),
                'channel' => $r->channel,
                'status'  => $r->status,
                'error'   => $r->error,
                'sent_at' => optional($r->sent_at)->toIso8601String(),
            ])
            ->values();

        return response()->json([
            'id'               => $message->id,
            'message_key'      => $message->message_key,
            'title'            => $message->title,
            'body'             => $message->body,
            'channels'         => $message->channels ?? [],
            'sent_by'          => $message->sender?->name ?? __('messaging.sender_system'),
            'status'           => $message->status,
            'recipients_count' => (int) $message->recipients_count,
            'delivered_count'  => (int) $message->delivered_count,
            'failed_count'     => (int) $message->failed_count,
            'created_at'       => optional($message->created_at)->toIso8601String(),
            'recipients'       => $recipients,
        ]);
    }

    /**
     * Re-dispatch a message to its failed recipients only.
     */
    public function resend(Message $message): RedirectResponse
    {
        $failed = $message->recipients()
            ->where('status', MessageRecipient::STATUS_FAILED)
            ->count();

        if ($failed === 0) {
            return redirect()
                ->route('messaging.history')
                ->with('info', __('messaging.resend_none'));
        }

        // Reset failed recipients to pending so the job re-processes only them.
        $message->recipients()
            ->where('status', MessageRecipient::STATUS_FAILED)
            ->update([
                'status'  => MessageRecipient::STATUS_PENDING,
                'error'   => null,
                'sent_at' => null,
            ]);

        $message->update(['status' => Message::STATUS_QUEUED]);

        SendCampaignMessage::dispatch($message);

        return redirect()
            ->route('messaging.history')
            ->with('success', __('messaging.resend_started', ['count' => $failed]));
    }

    /**
     * Send a message to the selected clients over the chosen channels.
     */
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_ids'   => ['required', 'array', 'min:1'],
            'client_ids.*' => ['integer', 'exists:clients,id'],
            'channels'     => ['required', 'array', 'min:1'],
            'channels.*'   => ['string', 'in:push,mail,whatsapp'],
            'title'        => ['required', 'string', 'max:150'],
            'message'      => ['required', 'string', 'max:2000'],
        ]);

        $channels = $validated['channels'];

        $clients = Client::whereIn('id', $validated['client_ids'])->get();

        // ── Persist the message (campaign) ──
        $message = Message::create([
            'title'            => $validated['title'],
            'body'             => $validated['message'],
            'channels'         => $channels,
            'sent_by'          => $request->user()?->id,
            'recipients_count' => $clients->count() * count($channels),
            'status'           => Message::STATUS_QUEUED,
        ]);

        // ── Create one recipient row per client × channel ──
        foreach ($clients as $client) {
            foreach ($channels as $channel) {
                $message->recipients()->create([
                    'client_id' => $client->id,
                    'channel'   => $channel,
                    'status'    => MessageRecipient::STATUS_PENDING,
                ]);
            }
        }

        // ── Dispatch background processing (push, mail, WhatsApp) ──
        SendCampaignMessage::dispatch($message);

        $labels = [
            'push'     => 'notification push',
            'mail'     => 'e-mail',
            'whatsapp' => 'WhatsApp',
        ];
        $used = implode(', ', array_map(fn($c) => $labels[$c] ?? $c, $channels));

        return redirect()
            ->route('messaging.index')
            ->with('success', "Message en cours d’envoi à {$clients->count()} client(s) via : {$used}.");
    }
}
