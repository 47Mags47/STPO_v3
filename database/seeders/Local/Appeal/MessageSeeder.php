<?php

namespace Database\Seeders\Local\Appeal;

use App\Models\Appeal\Appeal;
use App\Models\Appeal\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appeal::all()->each(fn($appeal) => Message::factory()->count(5)->for($appeal)->create());
    }
}
