<?php

namespace Database\Seeders\Local\Veteran;

use App\Models\Veteran\Date;
use App\Models\Veteran\Report;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Date::all()->each(fn($date) => Report::factory(5)->create([
            'date_id' => $date->id
        ]));
    }
}
