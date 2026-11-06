<?php

namespace App\Policies\Appeal;

use App\Models\Appeal\ThemeGroup;
use App\Models\Base\User;

class ThemeGroupPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('appeal_work');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('appeal_work');
    }

     public function update(User $user, ThemeGroup $them_group): bool
    {
        return $user->hasPermission('appeal_work');
    }

    public function delete(User $user, ThemeGroup $them_group): bool
    {
        return $user->hasPermission('appeal_work');
    }
}
