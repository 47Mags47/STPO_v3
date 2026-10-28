<?php

namespace Database\Factories\SFR\FSD;

use App\Models\Base\File;
use App\Models\SFR\FSD\SFRFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SFRFile>
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
            'in_date'       => now(),
            'date_start'    => now()->startOfMonth(),
            'date_end'      => now()->endOfMonth(),
            'file_id'       => File::randomOrCreate()
        ];
    }
}
