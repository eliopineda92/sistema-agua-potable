<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('user-roles.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('user-roles.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'required|array',
        ]);

        $user->roles()->sync($validated['roles']);

        return redirect()->route('user-roles.index')->with('success', 'Roles del usuario actualizados exitosamente.');
    }
}
