<?php

namespace Database\Seeders\Local\Veteran;

use App\Models\Veteran\Record;
use App\Models\Veteran\Report;
use Illuminate\Database\Seeder;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Record::factory(100)->create();
        Report::all()->each(fn($report) => Record::factory(5)->create([
            'report_id' => $report->id
        ]));
    }
}
