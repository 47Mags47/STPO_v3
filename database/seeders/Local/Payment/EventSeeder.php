<?php

namespace Database\Seeders\Local\Payment;

use App\Models\Payment\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::factory(3)->create([
            'in_day' => now(),
        ]);
    }
}
