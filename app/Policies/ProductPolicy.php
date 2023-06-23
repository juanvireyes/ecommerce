<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function view(User $user, Product $product): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function update(User $user, Product $product): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }
}
