<?php

namespace Database\Factories\Administrate;

use App\Models\Administrate\Law;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Law>
 */
class LawFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => rand(1, 999) . '-' . ((bool) rand(0, 1) ? 'ФЗ' : 'ОЗ'),
            'name' => 'test ' . $this->faker->text(),
        ];
    }
}
