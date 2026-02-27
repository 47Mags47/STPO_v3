<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\TemplateStyle;
use App\Models\TemplateType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => '$this->faker->word()',
            'file_id' => File::factory()->create([
                'disk' => 'templates',
            ]),
            'type_id' => TemplateType::all()->random()->id,
            'style_id' => TemplateStyle::all()->random()->id,
            'chunk' => $this->faker->boolean() ? rand(10, 1000) : null,
        ];
    }
}
