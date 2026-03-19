<?php

namespace App\Policies\Appeal;

use App\Models\Base\User;

class AppealPolicy
{
    public function accept(User $user): bool
    {
        return (bool) rand(0, 1);
    }

    public function goto(User $user): bool
    {
        return (bool) rand(0, 1);
    }

    public function close(User $user): bool
    {
        return (bool) rand(0, 1);
    }
}
