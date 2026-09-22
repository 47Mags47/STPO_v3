<?php

namespace App\Policies\Administrate;

use App\Models\Administrate\Law;
use App\Models\Base\User;

class LawPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('laws_administrate');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('laws_administrate');
    }

    /**
     * Determine whether the user can view model.
     */
    public function view(User $user, Law $law): bool
    {
        return $user->hasPermission('laws_administrate');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Law $law): bool
    {
        return $user->hasPermission('laws_administrate');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Law $law): bool
    {
        return $user->hasPermission('laws_administrate');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Law $law): bool
    {
        return $user->hasPermission('laws_administrate');
    }
}
