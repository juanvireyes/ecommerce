<?php

namespace App\Policies;

use App\Models\ProductRotationReport;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductRotationReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function view(User $user, ProductRotationReport $productRotationReport): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    public function update(User $user, ProductRotationReport $productRotationReport): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

}
