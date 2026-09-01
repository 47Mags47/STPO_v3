<?php

namespace Database\Seeders\Local\Administrate;

use App\Models\Administrate\Law;
use Illuminate\Database\Seeder;

class LawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Law::factory(10)->create();
    }
}
