<?php

namespace App\Policies\Administrate;

use App\Models\Administrate\Division;
use App\Models\Base\User;

class DivisionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('division_administrate');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('division_administrate');
    }

    /**
     * Determine whether the user can view model.
     */
    public function view(User $user, Division $division): bool
    {
        return $user->hasPermission('division_administrate');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Division $division): bool
    {
        return $user->hasPermission('division_administrate');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Division $division): bool
    {
        return $user->hasPermission('division_administrate');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Division $division): bool
    {
        return $user->hasPermission('division_administrate');
    }
}
