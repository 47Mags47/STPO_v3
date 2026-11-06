<?php

namespace Database\Factories\SFR\FSD;

use App\Models\SFR\FSD\ASPPaymentCategory;
use App\Models\SFR\FSD\SFRPaymentCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ASPPaymentCategory>
 */
class ASPPaymentCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                      => $this->faker->text(255),
            'sfr_payment_category_id'   => SFRPaymentCategory::randomOrCreate()->id
        ];
    }
}
