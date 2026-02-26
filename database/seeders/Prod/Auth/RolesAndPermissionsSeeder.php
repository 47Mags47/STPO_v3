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
        $roles['system_user']               = Role::create(['code' => 'system_user',              'name' => 'Системный пользователь']);

        $roles['csvi_sys_admin']            = Role::create(['code' => 'csvi_sys_admin',           'name' => 'Системный администратор ЦСВИ']);
        $roles['csvi_appeal_worker']        = Role::create(['code' => 'csvi_appeal_worker',       'name' => 'Работник обращений ЦСВИ']);

        ### Permissions
        $permissions = [];
        $permissions['roles_assigning']     = Permission::create(['code' => 'roles_assigning',    'name' => 'Назначение ролей']);
        $permissions['appeal_work']         = Permission::create(['code' => 'appeal_work',        'name' => 'Обработка обращений']);

        ## RolePermissions
        foreach ($permissions as $permission) {
            $roles['system_user']->permissions()->attach($permission->id);
        }
    }
}
