<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
    {
        $events = Event::with('organisateur', 'categorie')->get();
        return view('organisateur.dashboard', compact('events'));
    }

    // Show the form for creating a new event
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('admin', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'lieu' => 'required|string|max:255',
        'capacite' => 'required|integer|min:1',
        'statut' => 'required|in:publié,brouillon',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:6000',
        'categorie_id' => 'required|exists:categories,id',
    ]);


    $imagePath = $request->file('image')->store('events', 'public');

    // Create the event
    Event::create([
        'titre' => $validated['titre'],
        'description' => $validated['description'],
        'date' => $validated['date'],
        'lieu' => $validated['lieu'],
        'capacite' => $validated['capacite'],
        'statut' => $validated['statut'],
        'image' => $imagePath,
        'categorie_id' => $validated['categorie_id'],

        'organisateur_id' => Auth::id(),
    ]);

    return redirect()->back()->with('success', 'Événement créé avec succès.');
}

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $event = Event::findOrFail($id);
    return view('participant.details', compact('event'));
}

public function participer($id)
{
    $event = Event::findOrFail($id);
    // Logique pour participation (ex: enregistrer user)
    return redirect()->back()->with('success', 'Participation enregistrée !');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
{
    return view('organisateur.events.edit', compact('event'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $event = Event::findOrFail($id);

    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date',
        'lieu' => 'required|string',
        'capacite' => 'required|integer|min:1',
        'statut' => 'required|in:publié,brouillon',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
        $validated['image'] = $imagePath;
    }

    $event->update($validated);

    return redirect()->route('organisateur.dashboard')->with('success', 'Événement modifié avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('organisateur.dashboard')->with('success', 'event supprimé avec succès.');
    }


}
