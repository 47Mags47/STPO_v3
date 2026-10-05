<?php

namespace App\Events\Appeal;

use App\Models\Base\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    public function __construct(
        public ChatMessage $message,
        public int $appealId,
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('appeal.' . $this->appealId);
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return $this->message->toResource()->toArray(request());
    }
}
