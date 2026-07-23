<?php

namespace Database\Factories\Base;

use App\Models\Base\Chat;
use App\Models\Base\User;
use App\Models\Base\ChatSubscribers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChatSubscribers>
 */
class ChatSubscribersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chat_id' => Chat::randomOrCreate()->id,
            'user_id' => User::randomOrCreate()->id,
        ];
    }
}
