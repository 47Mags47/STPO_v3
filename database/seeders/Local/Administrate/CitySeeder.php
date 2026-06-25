<?php

namespace Database\Seeders\Local\Administrate;

use App\Models\Administrate\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::factory(35)->create();
    }
}
