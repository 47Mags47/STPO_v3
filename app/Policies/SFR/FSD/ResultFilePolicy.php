<?php

namespace App\Policies\SFR\FSD;

use App\Models\Base\User;

class ResultFilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can view model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermission('FSD_administrator');
    }
}
