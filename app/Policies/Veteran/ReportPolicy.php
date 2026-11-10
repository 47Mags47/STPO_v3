<?php

namespace App\Policies\Veteran;

use App\Models\Base\User;
use App\Models\Veteran\Report;

class ReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function report(User $user): bool
    {
        return $user->hasPermission('veteran_worker');
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('veteran_admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Report $report): bool
    {
        return $user->hasPermission('veteran_admin') or $user->hasPermission('veteran_worker');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('veteran_admin') or $user->hasPermission('veteran_worker');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Report $report): bool
    {
        return $user->hasPermission('veteran_admin');
    }
}
