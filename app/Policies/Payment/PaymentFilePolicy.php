<?php

namespace App\Policies\Payment;

use App\Models\Payment\PaymentFile;
use App\Models\Base\User;

class PaymentFilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('payment_file_upload');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('payment_file_upload');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PaymentFile $paymentFile): bool
    {
        return $user->hasPermission('payment_file_upload');
    }
}
