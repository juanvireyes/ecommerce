<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('users.user-dashboard', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        return view('superadmin.user', compact('user'));
    }

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

        return redirect()->route('users.edit', $user->id)
            ->with('success', 'Los datos han sido actualizados exitosamente');
    }
}
