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
        FileStatus::create(['code' => 'upload',    'name' => 'Загружается']);
        FileStatus::create(['code' => 'uploaded',  'name' => 'Загружен']);

        FileStatus::create(['code' => 'read',      'name' => 'Читается']);
        FileStatus::create(['code' => 'readed',    'name' => 'Считан']);
    }
}
