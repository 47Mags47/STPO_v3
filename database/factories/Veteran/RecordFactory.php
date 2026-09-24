<?php

namespace Database\Factories\Veteran;

use App\Models\Veteran\Record;
use App\Models\Veteran\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => random_int(1, 10000),
            'online_form' => random_int(1, 10000),
            'MFC' => random_int(1, 10000),
            'report_id' => Report::randomOrCreate()->id
        ];
    }
}
