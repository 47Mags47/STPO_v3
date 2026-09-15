<?php

namespace App\Traits;

use App\Models\Auth\Permission;
use App\Models\Administrate\Division;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Permissions
{
    ### Связи
    ##################################################
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'auth__user_pivot_permission', 'user_id', 'permission_id');
    }

    public function divisions(): BelongsToMany
    {
        return $this->belongsToMany(Division::class, 'auth__user_pivot_permission', 'user_id', 'division_id');
    }

    ### Методы
    ##################################################
    public function hasPermission(Permission|string $permission): bool
    {
        return $permission instanceof Permission
            ? $this->permissions->contains($permission)
            : $this->permissions->contains(Permission::byCode($permission));
    }

    public function addPermission(Permission|string $permission): self
    {
        $permission instanceof Permission
            ? $this->permissions()->attach($permission)
            : $this->permissions()->attach(Permission::byCode($permission));

        return $this;
    }

    public function deletePermission(Permission|string $permission): self
    {
        $permission instanceof Permission
            ? $this->permissions()->detach($permission)
            : $this->permissions()->detach(Permission::byCode($permission));

        return $this;
    }
}
