<?php

namespace App\Policies;

use App\Models\User;

class OrdersPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }
}
