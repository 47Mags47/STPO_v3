<?php

namespace App\Policies\Veteran;

use App\Models\Base\User;
use App\Models\Veteran\Date;

class DatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('veteran_admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('veteran_admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function view(User $user, Date $date): bool
    {
        return $user->hasPermission('veteran_admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function update(User $user, Date $date): bool
    {
        return $user->hasPermission('veteran_admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Date $date): bool
    {
        return $user->hasPermission('veteran_admin');
    }
}
