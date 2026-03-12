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
        $this->call(Administrate\DivisionSeeder::class);
        $this->call(Administrate\TemplateSeeder::class);

        $this->call(Appeal\AppealSeeder::class);

        $this->call(FSD\SFRFileSeeder::class);
        $this->call(FSD\RecipientSeeder::class);
        $this->call(FSD\PaymentFileSeeder::class);
        $this->call(FSD\PaymentSeeder::class);
    }
}
