<?php

namespace App\Policies\Appeal;

use App\Models\Appeal\ThemGroup;
use App\Models\Base\User;

class ThemGroupPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('appeal_them');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('appeal_them');
    }

     public function update(User $user, ThemGroup $them_group): bool
    {
        return $user->hasPermission('appeal_them');
    }

    public function delete(User $user, ThemGroup $them_group): bool
    {
        return $user->hasPermission('appeal_them');
    }
}
