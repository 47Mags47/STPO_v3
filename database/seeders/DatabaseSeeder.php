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
        exec('php artisan app:create-folders');

        switch (config('app.env')) {
            case 'production':
                $this->call(Prod\ProdSeeder::class);
                break;
            case 'local':
                $this->call(Prod\ProdSeeder::class);
                $this->call(Local\LocalSeeder::class);
                break;

            case 'testing':
                $this->call(Prod\ProdSeeder::class);
                $this->call(Test\TestSeeder::class);
                break;
        }
    }
}
