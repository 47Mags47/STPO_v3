<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(Administrate\CitySeeder::class);
        $this->call(Administrate\DivisionSeeder::class);

        $this->call(Base\UserSeeder::class);
    }
}
