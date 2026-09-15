<?php

namespace Database\Seeders\Prod\Auth;

use App\Models\Auth\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['code' => 'permission_assigning',       'name' => 'Назначение разрешений']);
        Permission::create(['code' => 'appeal_work',                'name' => 'Работа с обращениями']);
    }
}
