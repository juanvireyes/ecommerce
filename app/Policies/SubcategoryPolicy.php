<?php

namespace App\Policies;

use App\Models\Subcategory;
use App\Models\User;

class SubcategoryPolicy
{
    
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }
    
    public function view(User $user, Subcategory $subcategory): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }
    
    public function create(User $user): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }
    
    public function update(User $user, Subcategory $subcategory): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }
    
    public function delete(User $user, Subcategory $subcategory): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }

    public function restore(User $user, Subcategory $subcategory): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }
    
    public function forceDelete(User $user, Subcategory $subcategory): bool
    {
        return $user->hasRole(['superadmin', 'admin']);
    }
}
