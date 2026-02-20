<?php

namespace Database\Seeders\Prod\Base;

use App\Models\TemplateType;
use Illuminate\Database\Seeder;

class TemplateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TemplateType::create(['code' => 'test',   'name' => 'Тестовый шаблон']);
    }
}
