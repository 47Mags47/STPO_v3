<?php

namespace Database\Seeders\Prod;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(Base\TemplateStyleSeeder::class);
        $this->call(Base\TemplateTypeSeeder::class);

        $this->call(Auth\UserSeeder::class);
    }
}
