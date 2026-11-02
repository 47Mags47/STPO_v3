<?php

namespace Database\Factories\SFR\FSD;

use App\Models\Base\File;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class PaymentFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'in_date'   => now()->format('Y-m-d'),
            'file_id'   => File::randomOrCreate(),
        ];
    }
}
