<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperadminUpdateUser;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class SuperadminController extends Controller
{
    public function index(Request $request): View
    {

        $query = $this->filterUsers($request);
        $users = $query->latest()->paginate(12);

        return view('superadmin.users', compact('users'));
    }

    private function filterUsers(Request $request): EloquentBuilder
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
    
    public function edit(string $id): View
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        return view('superadmin.user', compact('user'));
    }

    public function update(SuperadminUpdateUser $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('users.edit', $user->id)
            ->with('success', 'Los datos han sido actualizados exitosamente');
    }
}
