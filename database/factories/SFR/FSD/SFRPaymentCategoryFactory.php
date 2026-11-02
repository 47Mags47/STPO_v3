<?php

namespace Database\Factories\SFR\FSD;

use App\Models\SFR\FSD\SFRPaymentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SFRPaymentCategory>
 */
class SFRPaymentCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pay_number'    => (string) $this->faker->numberBetween(1, 4),
            'name'          => $this->faker->text(255),
        ];
    }
}
