<?php

namespace App\Policies\SFR\FSD;

use App\Models\Base\User;
use App\Models\SFR\FSD\TransitCategory;

class TransitCategoryPolicy
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
     * Determine whether the user can update the model.
     */
    public function update(User $user, TransitCategory $category): bool
    {
        return $user->hasPermission('FSD_administrator');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TransitCategory $category): bool
    {
        return $user->hasPermission('FSD_administrator');
    }
}
