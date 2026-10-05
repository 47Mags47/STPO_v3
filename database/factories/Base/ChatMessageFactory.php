<?php

namespace Database\Factories\Base;

use App\Models\Base\Chat;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Base\ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chat = Chat::randomOrCreate();

        if($chat->subscribers()->count() === 0)
            $chat->subscribers()->attach(User::randomOrCreate()->id);

        return [
            'message' => $this->faker->text(250),

            'is_readed' => false,
            'is_system' => false,

            'chat_id' => $chat->id,
            'sender_id' => $chat->subscribers->random()->id,
        ];
    }
}
