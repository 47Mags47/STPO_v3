<?php

namespace App\Traits;

use App\Models\Auth\Permission;
use App\Models\Administrate\Division;
use App\Models\Auth\PermissionGroup;
use App\Models\Auth\UserPermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Permissions
{
    ### Связи
    ##################################################
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, UserPermission::getTableName(), 'user_id', 'permission_id')
            ->using(UserPermission::class)
            ->withPivot('division_id');
    }

    ### SCOPES
    ##################################################
    public static function scopeWhereHasPermissionGroup(Builder $query, PermissionGroup|string $permissionGroup)
    {
        $permissionGroup = $permissionGroup instanceof PermissionGroup
            ? $permissionGroup
            : PermissionGroup::byCode($permissionGroup);

        $permission_ids = $permissionGroup->permissions()->get('id')->pluck('id');

        return $query->whereHas('permissions', function ($query) use ($permission_ids) {
            $query->whereIn(Permission::getTableName() . '.id', $permission_ids);
        });
    }

    public static function scopeWhereHasPermission(Builder $query, Permission|string $permission): Builder
    {
        $permission = $permission instanceof Permission
            ? $permission
            : Permission::byCode($permission);

        return $query->whereHas('permissions', function ($query) use ($permission) {
            $query->where(Permission::getTableName() . '.id', $permission->id);
        });
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
