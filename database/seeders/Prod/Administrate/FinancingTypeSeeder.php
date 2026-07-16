<?php

namespace Database\Seeders\Prod\Administrate;

use App\Models\Administrate\FinancingType;
use Illuminate\Database\Seeder;

class FinancingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FinancingType::create(['name' => 'Региональный бюджет', 'sfr_fsd_code' => 'ДКР',    'asp_name' => 'Средства регионального бюджета']);
        FinancingType::create(['name' => 'Федеральный бюджет',  'sfr_fsd_code' => 'ДКФ',    'asp_name' => 'Средства федерального бюджета']);
    }
}
