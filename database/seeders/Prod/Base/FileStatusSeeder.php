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
        FileStatus::firstOrCreate(['code' => 'upload',    'name' => 'Загружается']);
        FileStatus::firstOrCreate(['code' => 'uploaded',  'name' => 'Загружен']);

        FileStatus::firstOrCreate(['code' => 'read',      'name' => 'Читается']);
        FileStatus::firstOrCreate(['code' => 'readed',    'name' => 'Считан']);
    }
}
