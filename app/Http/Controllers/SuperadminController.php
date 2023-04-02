<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Get superadmin role
        $superAdminRole = Role::where('name', 'superadmin')->firstOrFail();

        // Includes a search term
        $search = $request->search;

        // This part saves the query for retrieve users that doesn`t have a superadmin role
        $query = User::whereDoesntHave('roles', function ($query) use ($superAdminRole) {
            $query->where('role_id', $superAdminRole->id);
        });

        // Here validates if the search term has any value if don't, retrieves all users
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        // Here we optimize the query using paginate and adding other optimizations
        $users = $query->latest()->paginate(12);

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
        //
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

        $validated = $request->validate([
            'cellphone' => 'required|string|max:40',
            'address' => 'required|string|max:150',
            'city' => 'string|max:80',
            'state' => 'string|max:80',
            'country' => 'string|max:80',
            //'is_active' => 'required|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        //dd($request->all());

        $user->update($validated);

        session()->flash('success', 'El usuario ha sido actualizado correctamente.'); // This line sets a success message so it can be showed in the view when the user data is successfully updated

        //$user->save(); // For this case, is not necessary to save the user again. The update method saves the user with the updated data

        return redirect()->route('users.edit', $user->id)
            ->with('success', 'Los datos han sido actualizados exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
