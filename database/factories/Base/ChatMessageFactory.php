<?php

namespace Database\Factories\Base;

use App\Models\Base\Chat;
use App\Models\Base\ChatMessage;
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
        return [
            'message' => $this->faker->text(250),

            'is_readed' => false,
            'is_system' => false,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (ChatMessage $message) {
            if($message->chat_id === null){
                $message->chat = Chat::randomOrCreate();
            }
        });
    }
}
