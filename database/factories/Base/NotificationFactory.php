<?php

namespace Database\Factories\Base;

use App\Models\Base\File;
use App\Models\Base\Notification;
use App\Models\Base\NotificationType;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Base\Chat;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = NotificationType::get()->random();

        $attributes = [
            'recipient_id'  => User::randomOrCreate()->id,
            'sender_id'     => User::randomOrCreate()->id,
            'is_readed'     => $this->faker->boolean(),
            'type_id'       => $type->id,
            'message'       => null,
            'context'       => [],
            'created_at'    => now()->addHours(rand(-5, 5)),
        ];

        if ($type->code === 'file_generated') {
            $file = File::factory()->create();

            return array_merge($attributes, [
                'message'       => 'Файл ' . $file->origin_name . ' доступен для загрузки',
                'context'       => [
                    'file_id'   => $file->id,
                ]
            ]);
        }

        if ($type->code === 'new_message') {
            $chat = Chat::whereHas('messages')
                ->whereHas('appeal')
                ->inRandomOrder()
                ->first();
            $message = $chat->messages()->get()->random();
            $appeal = $chat->appeal()->get()->random();

            return array_merge($attributes, [
                'message'   => $message->message,
                'context'       => [
                    'chat_id'     => $message->chat_id,
                    'message_id'  => $message->id,
                    'appeal_id'   => $appeal->appeal_id
                ]
            ]);
        }

        return $attributes;
    }
}
