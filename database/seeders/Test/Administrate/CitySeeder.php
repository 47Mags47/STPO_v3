<?php

namespace Database\Seeders\Test\Administrate;

use App\Models\Administrate\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::factory(2)->create();
    }
}
