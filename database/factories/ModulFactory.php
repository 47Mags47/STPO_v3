<?php

namespace Database\Factories;

use App\Models\ModulGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Modul>
 */
class ModulFactory extends Factory
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
            'route_name' => $this->faker->word(),
            'group_id' => ModulGroup::randomOrCreate()->id,
            'creator_id' => null,
        ];
    }
}
