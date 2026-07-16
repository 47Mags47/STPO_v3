<?php

namespace Database\Seeders\Prod\Administrate;

use App\Models\Administrate\ModulGroup;
use Illuminate\Database\Seeder;

class ModulGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulGroup::firstOrCreate(['code' => 'administrate',   'name' => 'Администрирование']);
        ModulGroup::firstOrCreate(['code' => 'FSD_reestrs',    'name' => 'Реестры ФСД']);
        ModulGroup::firstOrCreate(['code' => 'payments',       'name' => 'Выплаты']);
    }
}
