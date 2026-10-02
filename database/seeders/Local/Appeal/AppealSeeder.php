<?php

namespace Database\Seeders\Local\Appeal;

use App\Models\Appeal\Appeal;
use App\Models\Base\ChatMessage;
use Illuminate\Database\Seeder;

class AppealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appeals = Appeal::factory(10)->create();
        $appeals->each(fn($appeal) => ChatMessage::factory(10)->create([
            'chat_id' => $appeal->chat_id,
            'created_at' => now()->subDay(rand(1,15)),
        ]));
    }
}
