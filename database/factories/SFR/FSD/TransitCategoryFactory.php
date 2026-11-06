<?php

namespace Database\Factories\SFR\FSD;

use App\Models\SFR\FSD\TransitCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransitCategory>
 */
class TransitCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wp_category_id'    => $this->faker->numberBetween(50, 100),
            'name'              => $this->faker->text()
        ];
    }
}
