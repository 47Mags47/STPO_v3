<?php

namespace Database\Factories\SFR\FSD;

use App\Models\Base\File;
use App\Models\SFR\FSD\TransitFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TransitFile>
 */
class TransitFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_start'    => now()->startOfMonth()->format('Y-m-d'),
            'date_end'      => now()->endOfMonth()->format('Y-m-d'),
            'file_id'       => File::randomOrCreate()
        ];
    }
}
