<?php

namespace Database\Seeders\Local\Base;

use Illuminate\Database\Seeder;
use App\Models\Base\ChatMessages;

class ChatMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatMessages::factory(50)->create();
    }
}
