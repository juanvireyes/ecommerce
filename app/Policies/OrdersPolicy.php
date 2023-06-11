<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

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
