<?php

namespace App\Events\Appeal;

use App\Models\Base\ChatMessages;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    public function __construct(
        public ChatMessages $message,
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
        return [
            'id'         => $this->message->id,
            'message'    => $this->message->message,
            'sender_id'  => $this->message->sender_id,
            'created_at' => $this->message->created_at,
            'file' => $this->message->file !== null
                ? [
                    'id' => $this->message->file->id,
                    'name' => $this->message->file->origin_name,
                ]
                : null,
            'file_url'   => $this->message->file !== null
                ? route('files.show', ['file' => $this->message->file->id])
                : null,
            'context'    => $this->message->context,
        ];
    }
}
