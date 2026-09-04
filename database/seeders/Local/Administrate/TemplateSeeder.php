<?php

namespace Database\Seeders\Local\Administrate;

use App\Models\Administrate\Template;
use App\Writers\Payment\ExampleWriter;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::factory()->create([
            'description' => 'Тестовый файл выгрузки выплаты в банк',
            'writer' => ExampleWriter::class,
        ]);
    }
}
