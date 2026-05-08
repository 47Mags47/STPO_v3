<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Base\TemplateType;
use Illuminate\Database\Seeder;

class TemplateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TemplateType::firstOrCreate(['code' => 'test',   'name' => 'Тестовый шаблон']);
    }
}
