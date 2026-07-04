<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CampaignProcessed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly Message $message)
    {
        //
    }

    /**
     * Channels: persist to DB + real-time push via Reverb.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->payload());
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->payload();
    }

    private function payload(): array
    {
        $labels = [
            Message::STATUS_SENT    => 'a été envoyée avec succès',
            Message::STATUS_PARTIAL => 'a été partiellement envoyée',
            Message::STATUS_FAILED  => 'a échoué',
        ];

        $statusText = $labels[$this->message->status] ?? 'a été traitée';

        return [
            'type'             => 'campaign_processed',
            'message_id'       => $this->message->id,
            'message_key'      => $this->message->message_key,
            'title'            => $this->message->title,
            'status'           => $this->message->status,
            'recipients_count' => (int) $this->message->recipients_count,
            'delivered_count'  => (int) $this->message->delivered_count,
            'failed_count'     => (int) $this->message->failed_count,
            'message'          => "Votre campagne « {$this->message->title} » {$statusText}. code : {$this->message->message_key}",
            'url'              => '/messaging/history',
        ];
    }
}
