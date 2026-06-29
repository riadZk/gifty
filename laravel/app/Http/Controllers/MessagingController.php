<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Message;
use App\Models\MessageRecipient;
use App\Notifications\AdminMessage;
use App\Services\WhatsAppService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
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

        $messageRows = $messages->map(fn (Message $m) => [
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
        $byDay = $messages->groupBy(fn (Message $m) => optional($m->created_at)->format('Y-m-d'));
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
        $title    = $validated['title'];
        $body     = $validated['message'];

        $clients = Client::whereIn('id', $validated['client_ids'])->get();

        // ── Persist the message (campaign) ──
        $message = Message::create([
            'title'            => $title,
            'body'             => $body,
            'channels'         => $channels,
            'sent_by'          => $request->user()?->id,
            'recipients_count' => $clients->count() * count($channels),
            'status'           => Message::STATUS_QUEUED,
        ]);

        // ── Create one recipient row per client × channel ──
        $recipients = [];
        foreach ($clients as $client) {
            foreach ($channels as $channel) {
                $recipients["{$client->id}:{$channel}"] = $message->recipients()->create([
                    'client_id' => $client->id,
                    'channel'   => $channel,
                    'status'    => MessageRecipient::STATUS_PENDING,
                ]);
            }
        }

        // ── Push + Mail via Laravel notifications ──
        $notifyChannels = array_values(array_intersect($channels, ['push', 'mail']));
        if (! empty($notifyChannels)) {
            try {
                Notification::send($clients, new AdminMessage($title, $body, $notifyChannels));
                foreach ($clients as $client) {
                    foreach ($notifyChannels as $channel) {
                        $recipients["{$client->id}:{$channel}"]?->markSent();
                    }
                }
            } catch (\Throwable $e) {
                foreach ($clients as $client) {
                    foreach ($notifyChannels as $channel) {
                        $recipients["{$client->id}:{$channel}"]?->markFailed($e->getMessage());
                    }
                }
            }
        }

        // ── WhatsApp handled separately (batch) ──
        if (in_array('whatsapp', $channels, true)) {
            $text = $title !== '' ? "*{$title}*\n\n{$body}" : $body;

            // Map normalized phone → recipient rows (skip clients without a phone).
            $phoneToRows = [];
            foreach ($clients as $client) {
                $row = $recipients["{$client->id}:whatsapp"] ?? null;
                if (! $row) {
                    continue;
                }
                $normalized = preg_replace('/\D+/', '', (string) $client->phone);
                if ($normalized === '' || $normalized === null) {
                    $row->markFailed('Numéro de téléphone manquant');
                    continue;
                }
                $phoneToRows[$normalized][] = $row;
            }

            if (! empty($phoneToRows)) {
                $result = WhatsAppService::sendMessage(array_keys($phoneToRows), $text);
                $detail = $result['detail'] ?? [];

                foreach ($phoneToRows as $phone => $rows) {
                    $sent = $detail[$phone] ?? ($result['ok'] ?? false);
                    foreach ($rows as $row) {
                        $sent ? $row->markSent() : $row->markFailed('Échec de l’envoi WhatsApp');
                    }
                }
            }
        }

        // ── Update aggregate counts + overall status ──
        $message->recomputeStatus();

        $labels = [
            'push'     => 'notification push',
            'mail'     => 'e-mail',
            'whatsapp' => 'WhatsApp',
        ];
        $used = implode(', ', array_map(fn ($c) => $labels[$c] ?? $c, $channels));

        return redirect()
            ->route('messaging.index')
            ->with('success', "Message envoyé à {$clients->count()} client(s) via : {$used}.");
    }
}
