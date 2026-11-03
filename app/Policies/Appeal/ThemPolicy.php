<?php

namespace App\Policies\Appeal;

use App\Models\Appeal\Them;
use App\Models\Base\User;

class ThemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('appeal_them');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('appeal_them');
    }

     public function update(User $user, Them $them): bool
    {
        return $user->hasPermission('appeal_them');
    }

    public function delete(User $user, Them $them): bool
    {
        return $user->hasPermission('appeal_them');
    }
}
