<?php

namespace Database\Factories\Payment;

use App\Models\Payment\PaymentFile;
use App\Models\Payment\Recipient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recipient>
 */
class RecipientFactory extends Factory
{
    public function definition(): array
    {
        $gender = $this->faker->boolean()
            ? 'male'
            : 'female';

        return [
            'file_id'           => PaymentFile::randomOrCreate(),

            'first_name'        => $this->faker->firstName($gender),
            'last_name'         => $this->faker->lastName($gender),
            'middle_name'       => $this->faker->firstName('male') . ($gender === 'male' ? 'ов' : 'ова'),
            'd_rojd'            => $this->faker->date(),
            'SNILS'             => $this->faker->numerify('###-###-### ##'),
            'account'           => $this->faker->numerify('####################'),
            'amount'            => $this->faker->randomFloat(2, 0, 10000),
            'p_series'          => $this->faker->numerify('####'),
            'p_number'          => $this->faker->numerify('######'),
            'p_date'            => $this->faker->date(),
            'p_div'             => $this->faker->company(),
        ];
    }
}
