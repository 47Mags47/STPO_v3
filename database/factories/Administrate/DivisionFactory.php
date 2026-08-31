<?php

namespace Database\Factories\Administrate;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Administrate\City;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DivisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'city_id' => City::randomOrCreate()->id,
        ];
    }
}
