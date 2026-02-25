<?php

namespace Database\Seeders\Prod\Base;

use App\Models\TemplateStyle;
use Illuminate\Database\Seeder;

class TemplateStyleSeeder extends Seeder
{
    public function run(): void
    {
        TemplateStyle::create(['code' => 'blade',   'name' => 'Программный blade шаблон']);
        TemplateStyle::create(['code' => 'xlsx',    'name' => 'Excel шаблон']);
    }
}
