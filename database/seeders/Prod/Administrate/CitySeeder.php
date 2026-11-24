<?php

namespace Database\Seeders\Prod\Administrate;

use App\Models\Administrate\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create(['name' => 'Кемерово']);
    }
}
