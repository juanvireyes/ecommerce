<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cellphone' => 'required|string|max:40',
            'address' => 'required|string|max:150',
            'city' => 'string|max:80',
            'state' => 'string|max:80',
            'country' => 'string|max:80'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'is_active' => true
        ]);

        //dd($user);

        event(new Registered($user));

        $role = Role::where('name', 'client')->first();
        $seeProducts = Permission::where('name', 'see products')->first();
        $editCart = Permission::where('name', 'edit shopping cart');

        $role->givePermissionTo($seeProducts, $editCart);
        $user->assignRole($role);

        Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);
        return redirect()->route('user.dashboard');
    }

    /**
     * Retrieve the Super Admin Registration form
     */

    public function createSuperAdmin(): View
    {
        return view('auth.saregister');
    }

    /**
     * Register new superadmin
     */
    public function storeSuperAdmin(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cellphone' => 'required|string|max:40',
            'address' => 'required|string|max:150',
            'city' => 'string|max:80',
            'state' => 'string|max:80',
            'country' => 'string|max:80'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'is_active' => true
        ]);

        //dd($user);

        event(new Registered($user));

        $role = Role::where('name', 'superadmin')->firstOrFail();

        $seeUsers = Permission::where('name', 'see users')->firstOrFail();
        $editUsers = Permission::where('name', 'edit users')->firstOrFail();
        $createProducts = Permission::where('name', 'create products')->firstOrFail();
        $editProducts = Permission::where('name', 'edit products')->firstOrFail();
        $deleteProducts = Permission::where('name', 'delete products')->firstOrFail();
        $seePayments = Permission::where('name', 'see payments')->firstOrFail();
        $approvePayments = Permission::where('name', 'approve payments')->firstOrFail();
        $seeProducts = Permission::where('name', 'see products')->firstOrFail();

        $role->givePermissionTo($seeProducts, $seeUsers, $editUsers, $createProducts, $editProducts, $deleteProducts, $seePayments, $approvePayments);
        $user->assignRole($role);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function createAdmin(): View
    {
        return view('auth.admin-register');
    }

    public function storeAdmin (Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cellphone' => 'required|string|max:40',
            'address' => 'required|string|max:150',
            'city' => 'string|max:80',
            'state' => 'string|max:80',
            'country' => 'string|max:80'
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cellphone' => $request->cellphone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'is_active' => true
        ]);

        //dd($user);

        event(new Registered($user));

        $role = Role::where('name', 'admin')->firstOrFail();

        $seeUsers = Permission::where('name', 'see users')->firstOrFail();
        $createProducts = Permission::where('name', 'create products')->firstOrFail();
        $editProducts = Permission::where('name', 'edit products')->firstOrFail();
        $deleteProducts = Permission::where('name', 'delete products')->firstOrFail();
        $seeProducts = Permission::where('name', 'see products')->firstOrFail();

        $role->givePermissionTo($seeProducts, $seeUsers, $createProducts, $editProducts, $deleteProducts);
        $user->assignRole($role);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }
}
