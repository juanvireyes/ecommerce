<?php

namespace App\Actions;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignRolesAndPermissionsAction {

    public function execute(User $user, string $role, array $permissions) {
        $role = Role::where('name', $role)->first();
        $permissions = Permission::whereIn('name', $permissions)->get();
        $role->givePermissionTo($permissions);
        $user->assignRole($role);
    }
}