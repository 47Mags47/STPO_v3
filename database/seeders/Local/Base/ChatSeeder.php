<?php

namespace Database\Seeders\Local\Base;

use App\Models\Base\Chat;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::factory(10)->create();
    }
}
