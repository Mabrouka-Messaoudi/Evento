<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
{
    $organisateurId = Auth::id();

    $events = Event::where('organisateur_id', $organisateurId)->get();

    $eventIds = $events->pluck('id');
    $reservations = Reservation::whereIn('event_id', $eventIds)->get();

    return view('organisateur.dashboard', compact('events', 'reservations'));
}




    public function createEvent()
    {

        return view('organisateur.events.creer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date',
        'lieu' => 'required|string|max:255',
        'capacite' => 'required|integer|min:1',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:6000',
        'categorie_id' => 'required|exists:categories,id',
    ]);


    $imagePath = $request->file('image')->store('events', 'public');

    // Create the event
    Event::create([
        'titre' => $validated['titre'],
        'description' => $validated['description'],
        'date_debut' => $validated['date_debut'],
        'date_fin' => $validated['date_fin'],
        'lieu' => $validated['lieu'],
        'capacite' => $validated['capacite'],
        'image' => $imagePath,
        'categorie_id' => $validated['categorie_id'],

        'organisateur_id' => Auth::id(),
    ]);

    return redirect()->back()->with('success', 'Événement créé avec succès.');
}

    /**
     * Display the specified resource.
     */
   public function show($id, $viewType = 'participant')
{
    $event = Event::with('avis.user')->findOrFail($id);

    if ($viewType === 'organisateur') {
        return view('organisateur.event_show', ['event' => $event]);
    }

    return view('participant.details', ['event' => $event]);
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
    public function events(Request $request)
{
    $categories = Category::all();
    $selectedCategory = $request->categorie_id;

    $eventsQuery = Event::query();

    if ($selectedCategory) {
        $eventsQuery->where('categorie_id', $selectedCategory);
    }

    $events = $eventsQuery->get();

    return view('participant.dashboard', compact('events', 'categories', 'selectedCategory'));
}
public function home()
{
    $today = Carbon::now();

    $events = Event::where('date_debut', '>=', $today)->get();
   return view('home.index', compact('events'));
}


}
