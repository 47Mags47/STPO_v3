<?php

namespace App\Events\Base;

use App\Classes\FileModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileChangeStatusEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public FileModel $file) {}

    public function broadcastOn(): array
    {
        return $this->file::$channel !== null
            ? [
                new PrivateChannel($this->file::$channel)
            ]
            : [];
    }

    public function broadcastAs(): string
    {
        return 'update';
    }

    public function broadcastWith()
    {
        return ['file' => $this->file->toResource()];
    }
}
