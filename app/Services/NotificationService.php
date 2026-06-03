<?php

namespace App\Services;

use App\Models\Notifications\AppNotification;
use App\Models\Notifications\AppNotificationType;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    public function create(
        int $recipientId,
        string $typeId,
        string $message
    ): AppNotification {
        // $typeId = NotificationType::where('code', $typeCode)->value('id');

        // if (!$typeId) {
        //     throw new \Exception("Notification type [$typeCode] not found");
        // }

        return AppNotification::create([
            'recipient_id' => $recipientId,
            'type_id' => $typeId,
            'message' => $message,
            'readed' => false,
        ]);
    }

    public function read(
        int $recipientId,
    ): Collection {
        return AppNotification::where('recipient_id', $recipientId)->latest()->get();
    }
}
