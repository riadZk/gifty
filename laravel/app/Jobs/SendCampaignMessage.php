<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\MessageRecipient;
use App\Notifications\AdminMessage;
use App\Notifications\CampaignProcessed;
use App\Services\WhatsAppService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class SendCampaignMessage implements ShouldQueue
{
    use Queueable;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Seconds to wait before retrying the job.
     *
     * @var array<int, int>
     */
    public array $backoff = [10, 30, 60];

    /**
     * The maximum number of seconds the job is allowed to run.
     */
    public int $timeout = 1800;

    /**
     * Create a new job instance.
     */
    public function __construct(public Message $message)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mark the campaign as currently being processed.
        $this->message->update(['status' => Message::STATUS_SENDING]);

        $channels = $this->message->channels ?? [];
        $title    = $this->message->title;
        $body     = $this->message->body;

        // Load pending recipient rows with their clients, keyed by "clientId:channel".
        $recipients  = [];
        $clientsById = [];

        $this->message->recipients()
            ->with('client')
            ->where('status', MessageRecipient::STATUS_PENDING)
            ->get()
            ->each(function (MessageRecipient $row) use (&$recipients, &$clientsById): void {
                $recipients["{$row->client_id}:{$row->channel}"] = $row;
                if ($row->client) {
                    $clientsById[$row->client_id] = $row->client;
                }
            });

        // ── Push + Mail via Laravel notifications (per client so one failure is isolated) ──
        $notifyChannels = array_values(array_intersect($channels, ['push', 'mail']));
        if (! empty($notifyChannels)) {
            foreach ($clientsById as $clientId => $client) {
                try {
                    Notification::send($client, new AdminMessage($title, $body, $notifyChannels));
                    foreach ($notifyChannels as $channel) {
                        $recipients["{$clientId}:{$channel}"]?->markSent();
                    }
                } catch (\Throwable $e) {
                    foreach ($notifyChannels as $channel) {
                        $recipients["{$clientId}:{$channel}"]?->markFailed($e->getMessage());
                    }
                }
            }
        }

        // ── WhatsApp handled separately (batch) ──
        if (in_array('whatsapp', $channels, true)) {
            $this->sendWhatsApp($title, $body, $recipients, $clientsById);
        }

        // ── Update aggregate counts + overall status ──
        $this->message->recomputeStatus();

        // ── Notify the user who created this campaign ──
        $this->notifySender();
    }

    /**
     * Notify the user who created the campaign that processing is complete.
     */
    protected function notifySender(): void
    {
        $sender = $this->message->sender;
        if ($sender) {
            $sender->notify(new CampaignProcessed($this->message->fresh()));
        }
    }

    /**
     * Send the WhatsApp messages in a single batch and update recipient rows.
     *
     * @param  array<string, MessageRecipient>  $recipients
     * @param  array<int, \App\Models\Client>  $clientsById
     */
    protected function sendWhatsApp(string $title, string $body, array $recipients, array $clientsById): void
    {
        $text = $title !== '' ? "*{$title}*\n\n{$body}" : $body;

        // Map normalized phone → recipient rows (skip clients without a phone).
        $phoneToRows = [];
        foreach ($clientsById as $clientId => $client) {
            $row = $recipients["{$clientId}:whatsapp"] ?? null;
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

        if (empty($phoneToRows)) {
            return;
        }

        try {
            $result = WhatsAppService::sendMessage(array_keys($phoneToRows), $text);
            $detail = $result['detail'] ?? [];

            foreach ($phoneToRows as $phone => $rows) {
                $sent = $detail[$phone] ?? ($result['ok'] ?? false);
                foreach ($rows as $row) {
                    $sent ? $row->markSent() : $row->markFailed('Échec de l’envoi WhatsApp');
                }
            }
        } catch (\Throwable $e) {
            foreach ($phoneToRows as $rows) {
                foreach ($rows as $row) {
                    $row->markFailed($e->getMessage());
                }
            }
        }
    }

    /**
     * Handle a job failure (after all retries are exhausted).
     */
    public function failed(\Throwable $exception): void
    {
        // Mark any remaining pending recipients as failed and finalize the status.
        $this->message->recipients()
            ->where('status', MessageRecipient::STATUS_PENDING)
            ->update([
                'status' => MessageRecipient::STATUS_FAILED,
                'error'  => $exception->getMessage(),
            ]);

        $this->message->recomputeStatus();

        // Notify the sender that the campaign failed.
        $this->notifySender();
    }
}
