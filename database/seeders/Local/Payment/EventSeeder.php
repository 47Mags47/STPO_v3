<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Payment\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        foreach (now()->startOfMonth()->toPeriod(now()->endOfMonth()) as $day) {
            Event::factory(rand(0, 3))->create([
                'in_day' => $day,
            ]);
        }
    }
}
