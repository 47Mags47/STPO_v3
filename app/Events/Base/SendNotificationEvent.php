<?php

namespace App\Events\Base;

use App\Models\Base\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Notification $notification) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->notification->recipient->id . '.notifications'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'new-notification';
    }

    public function broadcastWith()
    {
        return $this->notification->toResource()->toArray(request());
    }
}
