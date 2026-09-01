<?php

namespace Database\Factories\Administrate;

use App\Models\Administrate\Template;
use App\Models\Base\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Template>
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
            'description' => $this->faker->text(50),
            'writer' => null,
            'file_id' => File::createFromChildren(Template::class)->id
        ];
    }
}
