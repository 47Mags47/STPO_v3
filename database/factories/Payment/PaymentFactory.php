<?php

namespace Database\Factories\Payment;

use App\Models\Payment\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
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
        $code = $this->faker->unique()->numerify('###');

        return [
            'code' => $code,
            'name' => 'Выплата №' . $code . ' ' . $this->faker->word() . ' ' . $this->faker->word(),
            'kbk' => $this->faker->numerify('88810030240#########'),
        ];
    }
}
