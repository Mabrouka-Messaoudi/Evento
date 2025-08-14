<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    public function store(Request $request, $event_id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Avis::create([
            'event_id' => $event_id,
            'user_id' => Auth::id(), // utilisateur connecté
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Votre avis a été enregistré avec succès.');
    }
}
