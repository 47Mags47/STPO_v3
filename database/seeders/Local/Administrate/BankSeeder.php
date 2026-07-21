<?php

namespace Database\Seeders\Local\Administrate;

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
