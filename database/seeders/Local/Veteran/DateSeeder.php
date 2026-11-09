<?php

namespace Database\Seeders\Local\Veteran;

use App\Models\Veteran\Date;
use Illuminate\Database\Seeder;

class DateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Date::factory(5)->create(['is_active' => false]);
        Date::factory(1)->create([
            'in_date' => now()->startOfMonth(),
            'is_active' => true
        ]);
    }
}
