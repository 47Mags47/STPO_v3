<?php

namespace App\Events\Appeal;

use App\Models\Appeal\Appeal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class StatusChanged implements ShouldBroadcastNow
{
    public function __construct(
        public Appeal $appeal,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('statuses');
    }

    public function broadcastAs(): string
    {
        return 'status.changed';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->appeal->id,
            'status' => [
                'code' => $this->appeal->status->code,
                'name' => $this->appeal->status->name,
            ],
        ];
    }
}
