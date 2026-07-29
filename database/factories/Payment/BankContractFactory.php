<?php

namespace Database\Factories\Payment;

use App\Models\Administrate\Bank;
use App\Models\Administrate\Template;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BankContractFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number'        => Str::random(rand(3, 15)),
            'signed_at'     => now()->subDays(rand(0, 365))->format('Y-m-d'),

            'bank_id'       => Bank::randomOrCreate()->id,
            'template_id'   => Template::randomOrCreate()->id,
        ];
    }
}
