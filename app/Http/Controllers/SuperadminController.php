<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class SuperadminController extends Controller
{
    
    public function index(Request $request)
    {
        // $superAdminRole = Role::where('name', 'superadmin')->firstOrFail();

        // $search = $request->search;

        // $query = User::whereDoesntHave('roles', function ($query) use ($superAdminRole) {
        //     $query->where('role_id', $superAdminRole->id);
        // });

        // if ($search) {
        //     $query->where(function ($query) use ($search) {
        //         $query->where('name', 'LIKE', '%' . $search . '%')
        //             ->orWhere('email', 'LIKE', '%' . $search . '%');
        //     });
        // }

        $query = $this->filterUsers($request);

        $users = $query->latest()->paginate(12);

        return view('superadmin.users', compact('users'));
    }

    private function filterUsers(Request $request)
    {
        $superAdminRole = Role::where('name', 'superadmin')->first();

        $search = $request->search;

        $query = User::whereDoesntHave('roles', function ($query) use ($superAdminRole) {
            $query->where('role_id', $superAdminRole->id);
        });

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }
    
        return $query;
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
       $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $validated = $request->validate([
            'cellphone' => 'required|string|max:40',
            'address' => 'required|string|max:150',
            'city' => 'string|max:80',
            'state' => 'string|max:80',
            'country' => 'string|max:80',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        session()->flash('success', 'El usuario ha sido actualizado correctamente.');

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
