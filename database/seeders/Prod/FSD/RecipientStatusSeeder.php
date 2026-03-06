<?php

namespace Database\Seeders\Prod\FSD;

use App\Models\FSD\RecipientStatus;
use Illuminate\Database\Seeder;

class RecipientStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RecipientStatus::create(['code' => 'not check', 'name' => 'Не проверен']);
        RecipientStatus::create(['code' => 'not ащгтв', 'name' => 'Не найден']);
        RecipientStatus::create(['code' => 'check', 'name' => 'Проверен']);
    }
}
