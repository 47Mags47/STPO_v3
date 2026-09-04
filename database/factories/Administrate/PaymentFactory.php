<?php

namespace Database\Factories\Administrate;

use App\Models\Administrate\Law;
use App\Models\Administrate\Payment;
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
            'code'      => $code,
            'name'      => 'Выплата №' . $code . ' ' . $this->faker->word() . ' ' . $this->faker->word(),
            'kbk'       => $this->faker->numerify('88810030240#########'),
            'law_id'    => Law::randomOrCreate()->id,
        ];
    }
}
