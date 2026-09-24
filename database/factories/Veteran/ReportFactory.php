<?php

namespace Database\Factories\Veteran;

use App\Models\Veteran\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_at' => $this->faker
                ->unique()
                ->dateTimeBetween('today', '+3 months')
                ->format('Y-m-d'),
        ];
    }
}
