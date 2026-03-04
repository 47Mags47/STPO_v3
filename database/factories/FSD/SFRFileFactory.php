<?php

namespace Database\Factories\FSD;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SFRFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_id' => File::factory()->create([
                'disk' => 'fsd',
                'origin_name' => $this->faker->numerify('0523#' . rand(1, 12) . '#.000')
            ]),
            'region_code' => '052',
            'sign_code' => 3,
            'in_date' => Carbon::create(2026, 1),
            'npp_for_month' => 1
        ];
    }
}
