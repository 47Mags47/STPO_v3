<?php

namespace Database\Factories\SFR\FSD;

use App\Models\Administrate\Division;
use App\Models\SFR\FSD\PaymentFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentFile>
 */
class PaymentFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'in_date'       => now()->format('Y-m-d'),
            'division_id'   => Division::randomOrCreate(),
        ];
    }
}
