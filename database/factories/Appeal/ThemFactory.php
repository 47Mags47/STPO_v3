<?php

namespace Database\Factories\Appeal;

use App\Models\Appeal\ThemGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appeal\Them>
 */
class ThemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'group_id' => ThemGroup::randomOrCreate(),
        ];
    }
}
