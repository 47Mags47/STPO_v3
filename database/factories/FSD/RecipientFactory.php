<?php

namespace Database\Factories\FSD;

use App\Models\FSD\RecipientStatus;
use App\Models\FSD\SFRFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecipientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->boolean()
            ? 'male'
            : 'female';

        $first_name = $this->faker->firstName($gender);
        $last_name = $this->faker->lastName($gender);
        $middle_name = $this->faker->firstName('male') . ($gender === 'male' ? 'ов' : 'ова');

        return [
            'division_code'     => '0' . str_pad(rand(1, 46), 2, '0', STR_PAD_LEFT),
            'first_name'        => $first_name,
            'last_name'         => $last_name,
            'middle_name'       => $middle_name,
            'SNILS'             => $this->faker->numerify('###-###-### ##'),

            'file_id'           => SFRFile::randomOrCreate(),
            'status_id'         => RecipientStatus::all()->random()->id,
        ];
    }
}
