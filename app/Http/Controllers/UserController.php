<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get superadmin role
        $superAdminRole = Role::where('name', 'superadmin')->firstOrFail();

        // Get users -> This is the query where the superadmin can retrieve the list of all users that doesn't have superadmin role.
        $users = User::whereDoesntHave('roles', function($query) use($superAdminRole) {
            $query->where('role_id', $superAdminRole->id);
        })->latest()->paginate(12);

        // DB Query try -> Only retrieve users with al least one role. Users without roles are not retrieved
        /*$users = User::select('users.*')
                ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->where('model_has_roles.model_type', User::class)
                ->whereNotIn('users.id', function($query) use($superAdminRole) {
                    $query->select('model_id')
                          ->from('model_has_roles')
                          ->where('model_type', User::class)
                          ->where('role_id', $superAdminRole->id);
                })
                ->orWhereNull('model_has_roles.model_id')
                ->orderByDesc('created_at')
                ->paginate(12);*/
        
        // In both cases takes 5 querys to obtain the data. The uncommented case is the fastest one took 7.62ms to retrieve results. The commented one takes 9.62ms to show the same results

        return view('superadmin.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $this->authorize('update', $user);

        return view('superadmin.user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all());

        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        //dd($request->all());

        $user->is_active = $request->is_active;
        $user->save();

        return redirect()->route('users.edit', $user->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
