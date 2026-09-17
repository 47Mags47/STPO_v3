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
        return $this->belongsToMany(Permission::class, 'auth__user_pivot_permission', 'user_id', 'permission_id')
        ->withPivot('division_id');
    }

    ### Методы
    ##################################################
    public function hasPermission(Permission|string $permission): bool
    {
        return $permission instanceof Permission
            ? $this->permissions->contains($permission)
            : $this->permissions->contains(Permission::byCode($permission));
    }

    public function addPermission(Permission|string $permission, Division|null $division): self
    {
        $division = $division instanceof Division
            ? $division
            : Division::find($division);

        $permission = $permission instanceof Permission
            ? $permission
            : Permission::byCode($permission);

        $this->permissions()->attach($permission->id, ['division_id' => $division->id]);

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
