<?php

namespace Database\Factories\SFR\FSD;

use App\Models\SFR\FSD\ResultFile;
use App\Models\SFR\FSD\SFRFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResultFile>
 */
class ResultFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sfr_file_id'   => SFRFile::randomOrCreate()->id,
        ];
    }
}
