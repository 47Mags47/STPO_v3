<?php

namespace Database\Factories\SFR\FSD;

use App\Models\SFR\FSD\TransitCategory;
use App\Models\SFR\FSD\TransitEquivalent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransitEquivalent>
 */
class TransitEquivalentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'equivalent'    => $this->faker->randomFloat(2, 100, 1000),
            'date_start'    => now()->startOfYear()->format('Y-m-d'),
            'date_end'      => now()->endOfYear()->format('Y-m-d'),
            'category_id'   => TransitCategory::randomOrCreate()->id,
        ];
    }
}
