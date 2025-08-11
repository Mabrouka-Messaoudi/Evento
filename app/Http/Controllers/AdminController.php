<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function adminDashboard()
{
    $categories = Category::all();

    $users = User::whereIn('role', ['organisateur', 'participant'])->get();

    return view('admin.dashboard', compact('categories', 'users'));
}

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Utilisateur supprimé avec succès.');
    }
    public function store(Request $request){
        $request->validate([
            'nom' => 'required| string|max:255',

        ]);
        Category::create([
            'nom' => $request->nom,
        ]);
        return redirect()->back()->with('success', 'Catégorie ajoutée avec succès.');

    }
    public function destroyCategories(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.dashboard')->with('success', 'category supprimé avec succès.');
    }

public function edit(Category $category)
{
    return view('admin.categories.edit', compact('category'));
}

public function update(Request $request, Category $category): RedirectResponse
{
    $request->validate([
        'nom' => 'required|string|max:255',
    ]);

    $category->update([
        'nom' => $request->nom,
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Catégorie mise à jour avec succès.');
}





}
