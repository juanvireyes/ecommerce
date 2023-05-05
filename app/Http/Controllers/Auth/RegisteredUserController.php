<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('userRegisterLayout');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(StoreUserRequest $request):  RedirectResponse
    {

        $validatedData = $request->validated();
        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $validatedData['password'] = Hash::make($validatedData['password']);
     
        $user = User::create($validatedData);

        event(new Registered($user));

        $this->assignRolesAndPermissions($user, 'client', ['see products', 'edit shopping cart']);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    protected function assignRolesAndPermissions(User $user, string $role, array $permissions): void
    {
        $role = Role::where('name', $role)->first();
        $permissions = Permission::whereIn('name', $permissions)->get();
        $role->givePermissionTo($permissions);
        $user->assignRole($role);
    }

    /**
     * Retrieve the Super Admin Registration form
     */

    public function createSuperAdmin(): View
    {
        return view('userRegisterLayout');
    }

    /**
     * Register new superadmin
     */
    public function storeSuperAdmin(StoreUserRequest $request):  RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $validatedData['password'] = Hash::make($validatedData['password']);
     
        $user = User::create($validatedData);

        event(new Registered($user));

        $this->assignRolesAndPermissions($user, 'superadmin', ['see users', 'edit users', 'see products', 'edit products', 'delete products', 'see payments', 'approve payments']);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function createAdmin(): View
    {
        return view('userRegisterLayout');
    }

    public function storeAdmin (StoreUserRequest $request):  RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
        $validatedData['password'] = Hash::make($validatedData['password']);
     
        $user = User::create($validatedData);

        event(new Registered($user));

        $this->assignRolesAndPermissions($user, 'admin', ['see users', 'see products', 'edit products', 'delete products', 'see payments', 'approve payments']);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }
}
