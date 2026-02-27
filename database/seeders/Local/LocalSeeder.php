<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(Base\DivisionSeeder::class);
        $this->call(Base\TemplateSeeder::class);
        $this->call(Appeal\AppealSeeder::class);
    }
}
