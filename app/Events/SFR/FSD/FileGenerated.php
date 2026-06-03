<?php

namespace App\Events\SFR\FSD;

use App\Models\FSD\SFRFile;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileGenerated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public SFRFile $sfrFile,
        public $userId,
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('fsd.files');
        // return new PrivateChannel('fsd.files'.$this->userId);
    }

    public function broadcastAs(): string
    {
        return 'file.generated';
    }
}
