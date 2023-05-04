<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function view(User $user, Category $category): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function create(User $user, Category $category): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function update(User $user, Category $category): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Category $category): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

}
