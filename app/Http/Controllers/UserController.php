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
        $user = auth()->user();

        return view('users.user-dashboard', compact('user'));
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

        //$user->is_active = $request->is_active;
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
