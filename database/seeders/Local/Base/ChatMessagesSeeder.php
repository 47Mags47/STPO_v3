<?php

namespace Database\Seeders\Local\Base;

use App\Models\Base\Chat;
use Illuminate\Database\Seeder;
use App\Models\Base\ChatMessages;

class ChatMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::all()->each(function ($chat) {
            $subscribers = $chat->subscribers;

            $subscribers->each(function ($subscriber) use ($chat) {
                ChatMessages::factory(5)->create([
                    'chat_id' => $chat->id,
                    'sender_id' => $subscriber->user_id,
                ]);
            });
        });
    }
}
