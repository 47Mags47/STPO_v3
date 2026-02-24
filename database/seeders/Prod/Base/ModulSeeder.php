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
        Modul::create(['name' => 'Список групп модулей',    'route_name' => 'modul-groups', 'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список модулей',          'route_name' => 'moduls',       'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
        Modul::create(['name' => 'Список организаций',      'route_name' => 'divisions',    'group_id' => ModulGroup::byCode('administrate')->id, 'creator_id' => null]);
    }
}
