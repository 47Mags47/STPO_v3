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
        $chat = Chat::randomOrCreate();

        return [
            'chat_id' => $chat->id,
            'user_id' => User::whereNotIn('id', $chat->subscribers->pluck('user_id'))->get()->random()->id,
        ];
    }
}
