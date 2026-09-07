<?php

namespace Database\Factories\FSD;

use App\Models\Base\File;
use App\Models\SFR\FSD\PaymentFile;
use App\Models\SFR\FSD\SFRFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FSD\PaymentFile>
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
            'file_id' => File::createFromChildren(PaymentFile::class)->id,
            'sfr_file_id' => SFRFile::randomOrCreate()->id,
        ];
    }
}
