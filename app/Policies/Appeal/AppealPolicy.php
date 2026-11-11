<?php

namespace App\Policies\Appeal;

use App\Models\Appeal\Appeal;
use App\Models\Base\User;

class AppealPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, Appeal $appeal): bool
    {
        return $appeal->chat->subscribers()->where('user_id', $user->id)->exists();
    }

    public function accept(User $user, Appeal $appeal): bool
    {
        return $user->hasPermission('appeal_work');
    }

    public function close(User $user, Appeal $appeal): bool
    {
        return $appeal->sender_id === $user->id or $appeal->worker_id === $user->id;
    }

    public function reaccept(User $user, Appeal $appeal): bool
    {
        return
            $user->hasPermission('appeal_work')
            or $appeal->sender_id === $user->id
            or $appeal->worker_id === $user->id;
    }
}
