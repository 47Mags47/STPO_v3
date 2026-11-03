<?php

namespace App\Policies\Appeal;

use App\Models\Appeal\Appeal;
use App\Models\Base\User;

class AppealPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('appeal_work');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('appeal_work');
    }

    /**
     * Determine whether the user can view model.
     */
    public function view(User $user, Appeal $appeal): bool
    {
        return $user->hasPermission('appeal_work');
    }
}
