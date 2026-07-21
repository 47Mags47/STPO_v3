<?php

namespace Database\Factories\Payment;

use App\Models\Administrate\Bank;
use App\Models\Administrate\Division;
use App\Models\Base\File;
use App\Models\Payment\Event;
use App\Models\Payment\PaymentFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaymentFile>
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
            'file_id' => File::factory()->create()->id,
            'bank_id' => Bank::randomOrCreate(),
            'event_id' => Event::randomOrCreate(),
            'division_id' => Division::randomOrCreate(),
        ];
    }
}
