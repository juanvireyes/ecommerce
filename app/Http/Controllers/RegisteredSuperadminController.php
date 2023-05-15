<?php

namespace App\Http\Controllers;

use App\Actions\AssignRolesAndPermissionsAction;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Auth\RegisteredUserController;

class RegisteredSuperadminController extends RegisteredUserController
{
    public function create(): View
    {
        return view('userRegisterLayout');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $validatedData['password'] = Hash::make($validatedData['password']);
     
        $user = User::create($validatedData);

        event(new Registered($user));

        $assignRole = new AssignRolesAndPermissionsAction();
        $assignRole->execute($user, 'superadmin', ['see users', 'edit users', 'see products', 'edit products', 'delete products', 'see payments', 'approve payments']);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

}
