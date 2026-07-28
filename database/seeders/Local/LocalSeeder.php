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
        $this->call(Administrate\BankSeeder::class);
        $this->call(Administrate\PaymentSeeder::class);

        $this->call(Base\UserSeeder::class);

        $this->call(Base\ChatSeeder::class);
        $this->call(Base\ChatSubscribersSeeder::class);
        $this->call(Base\ChatMessagesSeeder::class);

        $this->call(Appeal\AppealSeeder::class);

        $this->call(Base\NotificationSeeder::class);

        $this->call(Payment\BankContractSeeder::class);
        $this->call(Payment\EventSeeder::class);
        $this->call(Payment\PaymentFileSeeder::class);
        $this->call(Payment\RecipientSeeder::class);
    }
}
