<?php

namespace Database\Factories\Base;

use App\Models\Base\File;
use App\Models\Appeal\Message;
use App\Models\Base\Notification;
use App\Models\Base\NotificationType;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
                    'file_id'   => $file->id
                ]
            ]);
        }

         if ($type->code === 'new_message') {
            $message = Message::factory()->create();

            return array_merge($attributes, [
                'message' => $this->faker->sentence(),
                'context' => [
                    'message_id' => $message->id
                ],
            ]);
        }

        return $attributes;
    }
}
