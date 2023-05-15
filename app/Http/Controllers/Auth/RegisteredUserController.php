<?php

namespace App\Http\Controllers\Auth;

use App\Actions\AssignRolesAndPermissionsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


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

        $assigRole = new AssignRolesAndPermissionsAction();
        $assigRole->execute($user, 'client', ['see products', 'edit shopping cart']);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

}
