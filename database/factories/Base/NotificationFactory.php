<?php

namespace Database\Factories\Base;

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
        return [
            'message'       => 'empty',
            'context'       => [],

            'is_readed'     => $this->faker->boolean(),

            'recipient_id'  => User::randomOrCreate()->id,
            'type_id'       => NotificationType::get()->random()->id,
            'sender_id'     => null,
        ];
    }
}
