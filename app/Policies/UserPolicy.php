<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('superadmin');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasRole('superadmin') || $user->id === $model->id;
    }
}
