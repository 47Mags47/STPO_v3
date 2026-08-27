<?php

namespace Database\Seeders\Test\Administrate;

use App\Models\Administrate\Division;
use App\Models\Administrate\City;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::all();

        // 2 города
        // 1 подразделение в каждом городе
        foreach ($cities as $city) {
            Division::factory()->create([
                'city_id' => $city->id
            ]);
        }
    }
}
