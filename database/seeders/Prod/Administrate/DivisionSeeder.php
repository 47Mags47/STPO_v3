<?php

namespace Database\Seeders\Prod\Administrate;

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
        Division::create(['name' => 'ЦСВИ', 'city_id' => City::where('name', 'Кемерово')->value('id')]);
    }
}
