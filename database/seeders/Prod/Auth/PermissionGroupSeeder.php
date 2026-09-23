<?php

namespace Database\Seeders\Prod\Auth;

use App\Models\Auth\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PermissionGroup::create(['code' => 'glossary_writer',   'name' => 'Работа со справочниками']);
        PermissionGroup::create(['code' => 'payment_work',      'name' => 'Работа с выплатами']);
        PermissionGroup::create(['code' => 'FSD',               'name' => 'Работа с файлами ФСД']);
        PermissionGroup::create(['code' => 'veteran_work',      'name' => 'Работа с заявлениями "Ветеран труда"']);
    }
}
