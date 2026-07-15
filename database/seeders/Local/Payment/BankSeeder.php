<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Administrate\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::factory(15)->create();
    }
}
