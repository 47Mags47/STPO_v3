<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Base\FileStatus;
use Illuminate\Database\Seeder;

class FileStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FileStatus::create(['code' => 'ok',         'name' => 'Ок']);
        FileStatus::create(['code' => 'creating',   'name' => 'Создается']);
        FileStatus::create(['code' => 'moving',     'name' => 'Перемещается']);
        FileStatus::create(['code' => 'reading',     'name' => 'Считывается']);
    }
}
