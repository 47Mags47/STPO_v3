<?php

namespace Database\Seeders\Local\Veteran;

use App\Models\Veteran\Report;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::factory(30)->create();
    }
}
