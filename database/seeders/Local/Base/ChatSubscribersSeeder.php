<?php

namespace Database\Seeders\Local\Base;

use App\Models\Base\ChatSubscribers;
use Illuminate\Database\Seeder;

class ChatSubscribersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatSubscribers::factory(10)->create();
    }
}
