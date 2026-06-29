<?php

namespace App\Notifications;

use App\Models\BonusRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewBonusRequest extends Notification
{
    use Queueable;

    public function __construct(public readonly BonusRequest $bonusRequest) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->payload());
    }

    public function toArray(object $notifiable): array
    {
        return $this->payload();
    }

    private function payload(): array
    {
        $client = $this->bonusRequest->client;
        $bonus  = $this->bonusRequest->bonusLevel;

        return [
            'type'             => 'new_bonus_request',
            'bonus_request_id' => $this->bonusRequest->id,
            'demande_key'      => $this->bonusRequest->demande_key,
            'client_id'        => $client?->id,
            'company_name'     => $client?->company_name,
            'bonus_name'       => $bonus?->reward_name,
            'points_required'  => (float) $this->bonusRequest->points_required,
            'message'          => 'Nouvelle demande bonus de ' . ($client?->company_name ?? '—') . ' — ' . ($bonus?->reward_name ?? '—'),
            'url'              => '/demandes/' . $this->bonusRequest->id,
        ];
    }
}
