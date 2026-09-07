<?php

namespace Database\Factories\Base;

use App\Models\Base\Chat;
use App\Models\Base\ChatMessages;
use App\Models\Base\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Base\ChatMessages>
 */
class ChatMessagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $chat = Chat::randomOrCreate();

        $subscribers = $chat->subscribers;

        return [
            'message' => $this->faker->text(250),
            'readed' => $this->faker->boolean(),
            'sender_id' => $subscribers->random()->user_id,
            'chat_id' => $chat->id,
            'context' => null,
            'file_id' => rand(0, 1)
                ? File::createFromChildren(ChatMessages::class)->id
                : null,
        ];
    }
}
