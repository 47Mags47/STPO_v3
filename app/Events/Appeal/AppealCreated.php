<?php

namespace App\Events\Appeal;

use App\Models\Appeal\Appeal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class AppealCreated implements ShouldBroadcastNow
{
    public function __construct(
        public Appeal $appeal,
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('appeals');
    }

    public function broadcastAs(): string
    {
        return 'appeal.created';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->appeal->id,
            'created' => $this->appeal->created_at->format('d.m.Y'),
            'comment' => $this->appeal->comment,
            'them' => [
                'id' => $this->appeal->them->id,
                'name' => $this->appeal->them->name,
                'group' => [
                    'name' => $this->appeal->them->group->name
                ]
            ],
            'status' => [
                'code' => $this->appeal->status->code,
                'name' => $this->appeal->status->name,
            ],
            'sender' => [
                'id' => $this->appeal->sender->id,
                'full_name' => $this->appeal->sender->full_name,
            ],

        ];
    }
}
