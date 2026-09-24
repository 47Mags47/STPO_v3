<?php

namespace Database\Seeders\Local\Veteran;

use App\Models\Veteran\Record;
use Illuminate\Database\Seeder;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Record::factory(100)->create();
    }
}
