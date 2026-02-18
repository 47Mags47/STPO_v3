<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        switch (config('app.env')) {
            case 'production':
                $this->call(Prod\ProdSeeder::class);
                break;
            case 'local':
                $this->call(Prod\ProdSeeder::class);
                $this->call(LocalSeeder::class);
                break;

            case 'test':
                $this->call(Prod\ProdSeeder::class);
                $this->call(TestSeeder::class);
                break;
        }
    }
}
