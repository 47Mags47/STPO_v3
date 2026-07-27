<?php

namespace Database\Factories\Base;

use App\Models\Base\Chat;
use App\Models\Base\File;
use App\Models\Base\User;
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

        $file = rand(0, 1)
            ? File::factory()->create([
                'disk' => 'appeals',
                'path' => 'messages/' . $chat->id
            ])
            : null;

        $subscribers = $chat->subscribers;

        return [
            'message' => $this->faker->text(250),
            'readed' => $this->faker->boolean(),
            'sender_id' => $subscribers->random()->user_id,
            'chat_id' => $chat->id,
            'context' => null,
            'file_id' => $file?->id,
        ];
    }
}
