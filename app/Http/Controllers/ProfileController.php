<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
{
    $user = auth()->user();
    return view('profile.edit', compact('user'));
}


    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'prenom' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'telephone' => 'required|string|max:20',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'adresse' => 'required|string|max:255',
    ]);

    $user->update($request->only('prenom', 'nom', 'telephone', 'email', 'adresse'));

    return redirect()->route('profile.edit')->with('success', 'Profil mis à jour avec succès.');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
{
    $user = auth()->user();

    // Optional: Confirm password before deleting (recommended for security)
    $request->validate([
        'password' => ['required', 'current_password'],
    ]);

    // Log out user before deleting
    auth()->logout();

    // Delete user record
    $user->delete();

    // Redirect to homepage or goodbye page
    return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
}

}
