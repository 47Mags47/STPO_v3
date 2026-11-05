<?php

namespace App\Policies\Payment;

use App\Models\Base\User;

class BankPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('payment_event_view');
    }
}
