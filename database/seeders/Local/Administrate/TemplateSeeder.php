<?php

namespace Database\Seeders\Local\Administrate;

use App\Models\Administrate\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::factory(10)->create();
    }
}
