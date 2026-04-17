<?php

namespace App\Events\SFR\FSD;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SFRFileChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct() {}

    public function broadcastOn(): Channel
    {
        return new Channel('sfr.fsd.sfr-file');
    }

    public function broadcastAs(): string
    {
        return 'change';
    }
}
