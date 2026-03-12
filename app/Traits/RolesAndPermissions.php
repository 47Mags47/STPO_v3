<?php

namespace App\Traits;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait RolesAndPermissions
{
    ### Связи
    ##################################################
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'auth__users_pivot_roles')->withPivot('division_id', 'modul_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'auth__users_pivot_permissions');
    }

    ### Методы
    ##################################################
    public function addRole(mixed $role, ?array $params = []): self
    {
        $this->roles()->attach(Role::getId($role), $params);

        return $this;
    }

    public function addPermission(mixed $permission): self
    {
        if(!$this->hasPermission($permission))
            $this->permissions()->attach(Permission::getId($permission));

        return $this;
    }

    public function hasRole(mixed $role): bool
    {
        return $this->roles()->where('role_id', Role::getId($role))->exists();
    }

    public function hasPermission(mixed $permission): bool
    {
        return
            $this->roles()->whereHas('permissions', fn($query) => $query->where('permission_id', Permission::getId($permission)))->exists()
            or
            $this->permissions()->where('permission_id', Permission::getId($permission))->exists();
    }

    public function deleteRole(mixed $role): self
    {
        $this->roles()->detach(Role::getId($role));

        return $this;
    }

    public function deletePermission(mixed $permission): self
    {
        $this->permissions()->detach(Permission::getId($permission));

        return $this;
    }
}
