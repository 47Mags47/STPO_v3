<?php

namespace Database\Factories\Payment;

use App\Models\Administrate\Bank;
use App\Models\Base\File;
use App\Models\Payment\BankRaport;
use App\Models\Payment\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<BankRaport>
 */
class BankRaportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_id' => File::createFromChildren(BankRaport::class),
            'bank_id' => Bank::randomOrCreate(),
            'event_id' => Event::randomOrCreate(),
        ];
    }
}
