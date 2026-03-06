<?php

namespace Database\Factories\FSD;

use App\Models\FSD\PaymentFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FSD\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'raport_date'   => now(),
            'type_number'   => rand(1, 4),
            'type_name'     => ['ДЭФ', 'ДЭР', 'ДКФ', 'ДКР', 'МСПР'][rand(0,4)],
            'amount'        => $this->faker->randomFloat(2, 0, 999999),
            'amount_other'  => 0.00,
            'start_date'    => now()->startOfMonth(),
            'end_date'      => now()->endOfMonth(),

            'file_id'       => PaymentFile::randomOrCreate()->id,
            'recipient_id'  => null,
        ];
    }
}
