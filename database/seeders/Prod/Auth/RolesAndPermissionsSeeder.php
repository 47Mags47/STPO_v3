<?php

namespace Database\Seeders\Prod\Auth;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ### Roles
        $roles = [];
        $roles['root']                  = Role::create(['code' => 'root',               'name' => 'Системный пользователь']);
        $roles['csvi_sys_admin']        = Role::create(['code' => 'csvi_sys_admin',     'name' => 'Системный администратор ЦСВИ']);
        $roles['csvi_appeal_worker']    = Role::create(['code' => 'csvi_appeal_worker', 'name' => 'Работник обращений ЦСВИ']);

        ### Permissions
        $permissions = [];
        $permissions['roles_assigning']     = Permission::create(['code' => 'roles_assigning',    'name' => 'Назначение ролей']);
        $permissions['appeal_work']         = Permission::create(['code' => 'appeal_work',        'name' => 'Обработка обращений']);

        ## RolePermissions
        foreach ($permissions as $permission) {
            $roles['root']->permissions()->attach($permission->id);
        }
    }
}
