<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function broadcastOn(): array
    {
        return [ new Channel('notif-received') ]; // ⬅ public, no auth hit
    }

    // Optional: give the event a custom name
    public function broadcastAs(): string
    {
        return 'NotificationReceived';
    }

    // ✅ This makes the JSON be exactly what you return here
    public function broadcastWith(): array
    {
        return [
            'sensor_type'   => $this->payload['sensor_type'] ?? null,
            'sensor_status' => $this->payload['sensor_status'] ?? null,
            'created_at'    => isset($this->payload['created_at'])
                ? Carbon::parse($this->payload['created_at'])->toISOString()
                : null,
            'isRead' => $this->payload['isRead'] ?? null,
        ];
    }
}

