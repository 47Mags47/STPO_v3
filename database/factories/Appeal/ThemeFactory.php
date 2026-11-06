<?php

namespace Database\Factories\Appeal;

use App\Models\Appeal\ThemeGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appeal\Theme>
 */
class ThemeFactory extends Factory
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
            'group_id' => ThemeGroup::randomOrCreate(),
        ];
    }
}
