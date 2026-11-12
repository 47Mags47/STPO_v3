<?php

namespace Database\Seeders\Local\Base;

use App\Models\Base\Notification;
use App\Models\Base\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            Notification::factory(5)->create([
                'recipient_id' => $user->id
            ]);
        });
    }
}
