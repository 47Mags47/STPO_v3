<?php

namespace Database\Seeders\Prod\Administrate;

use App\Models\Administrate\Modul;
use App\Models\Administrate\ModulGroup;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modul::create(['name' => 'Список групп модулей',    'route_name' => 'administrate.modul-groups.index', 'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список модулей',          'route_name' => 'administrate.moduls.index',       'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список организаций',      'route_name' => 'administrate.divisions.index',    'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список пользователей',    'route_name' => 'administrate.users.index',        'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список шаблонов',         'route_name' => 'administrate.templates.index',    'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
    }
}
