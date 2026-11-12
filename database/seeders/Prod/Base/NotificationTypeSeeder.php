<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Base\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    public function run(): void
    {
        NotificationType::create([
            'code' => 'file',
            'name'=> 'Файл',
        ]);
        NotificationType::create([
            'code' => 'message',
            'name'=> 'Сообщение',
        ]);
        NotificationType::create([
            'code' => 'info',
            'name'=> 'Информационное собщение',
        ]);
        NotificationType::create([
            'code' => 'alert',
            'name'=> 'Оповещение',
        ]);
    }
}
