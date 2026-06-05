<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Payment\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::factory(10)->create();
    }
}
