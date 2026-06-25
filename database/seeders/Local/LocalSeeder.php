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
        $this->call(Administrate\CitySeeder::class);
        $this->call(Administrate\DivisionSeeder::class);

        $this->call(Base\UserSeeder::class);
        $this->call(Base\NotificationSeeder::class);

        $this->call(Appeal\AppealSeeder::class);
        $this->call(Appeal\MessageSeeder::class);

        $this->call(Payment\BankSeeder::class);
        $this->call(Payment\PaymentSeeder::class);
        $this->call(Payment\EventSeeder::class);
    }
}
