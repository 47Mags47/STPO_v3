<?php

namespace Database\Seeders\Local\Base;

use App\Models\Base\Chat;
use App\Models\Base\ChatSubscribers;
use Illuminate\Database\Seeder;

class ChatSubscribersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::all()->each(function($chat){
            ChatSubscribers::factory(2)->create([
                'chat_id' => $chat->id
            ]);
        });
    }
}
