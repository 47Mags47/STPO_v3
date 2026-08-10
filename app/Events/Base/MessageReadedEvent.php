<?php

namespace App\Events\Base;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Collection;

class MessageReadedEvent implements ShouldBroadcastNow
{
    public function __construct(
        public Collection $messages,
        public int $chatId,
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('appeal.' . $this->chatId);
    }

    public function broadcastAs(): string
    {
        return 'message.readed';
    }

    public function broadcastWith(): array
    {
        return [
            'messages' => $this->messages->map(fn ($message) => [
                'id' => $message->id,
                'message' => $message->message,
                'readed' => $message->readed,
            ]),
        ];
    }
}
