<?php

namespace Database\Factories\Payment;

use App\Models\Administrate\Payment;
use App\Models\Payment\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'in_date' => now()->addDays(rand(-10, 10)),
            'payment_id' => Payment::randomOrCreate()->id,
        ];
    }
}
