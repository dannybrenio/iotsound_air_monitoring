<?php

namespace App\Events;

use App\Models\Hardware_data;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReadingReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public array $reading) {}

    // Public channel named "readings"
    public function broadcastOn(): Channel
    {
        return new Channel('readings');
    }

    // Optional: nice event name for the frontend
    public function broadcastAs(): string
    {
        return 'reading.received';
    }

}
