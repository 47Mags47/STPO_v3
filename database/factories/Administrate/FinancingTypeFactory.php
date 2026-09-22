<?php

namespace Database\Factories\Administrate;

use App\Models\Administrate\FinancingType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FinancingType>
 */
class FinancingTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'          => 'Тестовый',
            'sfr_fsd_code'  => 'ТЕСТ',
            'asp_name'      => 'Тестовый'
        ];
    }
}
