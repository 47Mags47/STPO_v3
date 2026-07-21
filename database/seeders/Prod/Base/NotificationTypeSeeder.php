<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Base\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    public function run(): void
    {
        NotificationType::create([
            'code' => 'file_generated',
            'name'=> 'Файл готов к загрузке',
        ]);
        NotificationType::create([
            'code' => 'new_message',
            'name'=> 'Новое сообщение в чате',
        ]);
    }
}
