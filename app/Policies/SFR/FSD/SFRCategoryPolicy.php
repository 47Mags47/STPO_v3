<?php

namespace App\Policies\SFR\FSD;

use App\Models\Base\User;
use App\Models\SFR\FSD\ASPPaymentCategory;

class SFRCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can view model.
     */
    public function view(User $user): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ASPPaymentCategory $category): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ASPPaymentCategory $category): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ASPPaymentCategory $category): bool
    {
        return $user->hasPermission('FSD_administrator');
    }
}
