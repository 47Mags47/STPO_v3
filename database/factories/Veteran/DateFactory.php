<?php

namespace Database\Factories\Veteran;

use App\Models\Veteran\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class DateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'in_date' => now()
                ->addMonth($this->faker->numberBetween(-5, 5))
                ->startOfMonth()
                ->format('Y-m-d'),
            'is_active' => $this->faker->boolean()
        ];
    }
}
