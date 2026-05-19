<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Base\TemplateStyle;
use Illuminate\Database\Seeder;

class TemplateStyleSeeder extends Seeder
{
    public function run(): void
    {
        TemplateStyle::firstOrCreate(['code' => 'blade',   'name' => 'Программный blade шаблон']);
        TemplateStyle::firstOrCreate(['code' => 'xlsx',    'name' => 'Excel шаблон']);
    }
}
