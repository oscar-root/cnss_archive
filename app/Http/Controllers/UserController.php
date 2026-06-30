<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // READ : Liste des utilisateurs
    public function index()
    {
        // On récupère tous les utilisateurs sauf celui connecté pour éviter l'auto-suppression
        $users = User::where('id', '!=', auth()->id())->latest()->get();
        return view('users.index', compact('users'));
    }

    // CREATE : Enregistrement
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,secretaire,chef_de_service,directeur'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    // UPDATE : Formulaire d'édition
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // UPDATE : Enregistrement des modifications
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,secretaire,chef_de_service,directeur'],
            'password' => ['nullable', Rules\Password::defaults()], // Mot de passe optionnel à la modif
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Compte utilisateur mis à jour.');
    }

    // DELETE : Suppression
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé définitivement.');
    }
}