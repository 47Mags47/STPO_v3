<?php

namespace Database\Seeders\Local\Administrate;

use App\Models\Administrate\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::factory(5)->create();
    }
}
