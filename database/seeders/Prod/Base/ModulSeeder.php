<?php

namespace Database\Seeders\Prod\Base;

use App\Models\Modul;
use App\Models\ModulGroup;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modul::create(['name' => 'Список групп модулей',    'route_name' => 'modul-groups.index', 'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список модулей',          'route_name' => 'moduls.index',       'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список организаций',      'route_name' => 'divisions.index',    'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список пользователей',    'route_name' => 'users.index',        'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список шаблонов',         'route_name' => 'templates.index',    'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
    }
}
