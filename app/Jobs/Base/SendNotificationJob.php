<?php

namespace App\Jobs\Base;

use App\Events\Base\SendNotificationEvent;
use App\Models\Base\Notification;
use App\Models\Base\NotificationType;
use App\Models\Base\User;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable, Batchable;

    private Notification $notification;

    public function __construct(
        public User|int $user,
        public NotificationType|int|string $type,
        public string $message = '',
        public array $context = [],
    ) {
        $this->onQueue('notifications');

        if (is_int($user))
            $user = User::wherekey($user)->first();

        if ($user instanceof User)
            $user = $user;

        if (is_int($type))
            $type = NotificationType::wherekey($type)->first();

        if (is_string($type))
            $type = NotificationType::byCode($type);

        if ($type instanceof NotificationType)
            $type = $type;

        $this->notification = Notification::create([
            'recipient_id' => $user->id,
            'type_id' => $type->id,
            'message' => $message,
            'context' => $context,
        ]);
    }

    public function handle(): void
    {
        SendNotificationEvent::dispatch($this->notification);
    }
}
