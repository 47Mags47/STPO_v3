<?php

namespace App\Policies\Administrate;

use App\Models\Administrate\Bank;
use App\Models\Base\User;

class BankPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('banks_administrate');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('banks_administrate');
    }

    /**
     * Determine whether the user can view model.
     */
    public function view(User $user, Bank $bank): bool
    {
        return $user->hasPermission('banks_administrate');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bank $bank): bool
    {
        return $user->hasPermission('banks_administrate');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bank $bank): bool
    {
        return $user->hasPermission('banks_administrate');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bank $bank): bool
    {
        return $user->hasPermission('banks_administrate');
    }
}
