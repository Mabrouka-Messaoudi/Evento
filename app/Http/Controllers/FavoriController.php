<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriController extends Controller
{
    /**
     * Affiche la liste des favoris de l'utilisateur connecté
     */
    public function index()
    {
        $favoris = Auth::user()->favoris()->with('event')->get();

        return view('participant.favoris.index', compact('favoris'));
    }

    /**
     * Ajoute un événement aux favoris
     */
    public function store($event_id)
    {
        Favori::firstOrCreate([
            'user_id'  => Auth::id(),
            'event_id' => $event_id,
        ]);

        return redirect()->back()->with('success', 'Événement ajouté aux favoris ⭐');
    }

    /**
     * Supprime un événement des favoris
     */
    public function destroy($event_id)
    {
        $favori = Favori::where('user_id', Auth::id())
                        ->where('event_id', $event_id)
                        ->first();

        if ($favori) {
            $favori->delete();
            return redirect()->back()->with('success', 'Événement retiré des favoris ❌');
        }

        return redirect()->back()->with('error', 'Ce favori n’existe pas.');
    }
    public function toggle($event_id)
{
    $user = Auth::user();

    $favori = Favori::where('user_id', $user->id)
                     ->where('event_id', $event_id)
                     ->first();

    if($favori) {
        $favori->delete(); // Retire des favoris
    } else {
        Favori::create([
            'user_id' => $user->id,
            'event_id' => $event_id
        ]); // Ajoute aux favoris
    }

    return redirect()->back();
}


}
