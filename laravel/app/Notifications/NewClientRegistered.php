<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewClientRegistered extends Notification
{
    use Queueable;

    public function __construct(public readonly Client $client) {}

    /**
     * Channels: persist to DB + real-time push via Reverb.
     * Broadcasts on: private-App.Models.User.{notifiable->id}
     */
    public function via(object $notifiable): array
    {
        return ["database", "broadcast"];
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
        return [
            "type"         => "new_client_registered",
            "client_id"    => $this->client->id,
            "company_name" => $this->client->company_name,
            "email"        => $this->client->email,
            "phone"        => $this->client->phone,
            "message"      => "Nouveau client inscrit : " . $this->client->company_name,
            "url"          => "/clients/" . $this->client->id,
        ];
    }
}
