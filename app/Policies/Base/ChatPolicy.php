<?php

namespace App\Policies\Base;

use App\Models\Base\Chat;
use App\Models\Base\User;

class ChatPolicy
{
    public function view(User $user, Chat $chat): bool
    {
        return $chat->subscribers()->where('user_id', $user->id)->exists();
    }
}
