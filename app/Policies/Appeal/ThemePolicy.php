<?php

namespace App\Policies\Appeal;

use App\Models\Appeal\Theme;
use App\Models\Base\User;

class ThemePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('appeal_work');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('appeal_work');
    }

     public function update(User $user, Theme $them): bool
    {
        return $user->hasPermission('appeal_work');
    }

    public function delete(User $user, Theme $them): bool
    {
        return $user->hasPermission('appeal_work');
    }
}
