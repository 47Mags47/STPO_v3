<?php

namespace Database\Seeders\Local\Base;

use App\Models\Base\Chat;
use Illuminate\Database\Seeder;
use App\Models\Base\ChatMessage;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::all()->each(function ($chat) {
            $subscribers = $chat->subscribers;

            $subscribers->each(function ($subscriber) use ($chat) {
                ChatMessage::factory(5)->create([
                    'chat_id' => $chat->id,
                    'sender_id' => $subscriber->id,
                ]);
            });
        });
    }
}
