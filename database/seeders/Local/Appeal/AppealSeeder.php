<?php

namespace Database\Seeders\Local\Appeal;

use App\Models\Appeal\Appeal;
use Illuminate\Database\Seeder;

class AppealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appeal::factory(10)->create();
    }
}
