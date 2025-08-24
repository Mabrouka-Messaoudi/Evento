<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Event;
use Carbon\Carbon;


class ChatbotController extends Controller{



    public function handle(Request $request)
{
    $userMessage = $request->message;
    $user = $request->user(); // optionnel si vous voulez des recommandations personnalisées

    $reply = 'Pas de réponse pour le moment.';

    // 1️⃣ Vérification des FAQ
    $faq = [
    'lieu' => '📍 Tous les événements se déroulent au Centre Ville sauf indication contraire.',
    'participation' => '📝 Inscription: Cliquez sur "participer" sur la page de l\'événement. Paiement sécurisé disponible.',
    'heure' => '⏰ Horaires: Généralement à 18h00. Consultez chaque événement pour les horaires exacts.',
    'annulation' => '❌ Annulation: Possible jusqu\'à 24h avant l\'événement. Contactez le support.',
    'certificat' => '📄 Certificat: Un certificat de participation est remis après chaque événement.',
    'nourriture' => '🍕 Repas: Des rafraîchissements sont généralement prévus lors des événements.',
    'parking' => '🚗 Parking: Parking gratuit disponible à proximité du Centre Ville.',
    'handicap' => '♿ Accessibilité: Tous nos sites sont accessibles aux personnes à mobilité réduite.',
];

    foreach($faq as $motCle => $reponse){
        if(stripos($userMessage, $motCle) !== false){
            $reply = $reponse;
            return response()->json(['reply' => $reply]);
        }
    }

    // 2️⃣ Découverte d’événements (mots-clés : "semaine", "demain", "aujourd'hui", "événements")
        $keywords = ['semaine', 'demain', 'aujourd\'hui', 'aujourdhui', 'événements', 'evenements', 'event', 'évènements'];
$found = false;
foreach ($keywords as $keyword) {
    if (stripos($userMessage, $keyword) !== false) {
        $found = true;
        break;
    }
}

if ($found) {
    $events = Event::where('date_debut', '>=', Carbon::now())
                   ->orderBy('date_debut', 'asc')
                   ->take(5)
                   ->get();

    // DEBUG : vérifie si la requête retourne quelque chose
    if ($events->isEmpty()) {
        $reply = "Aucun événement trouvé. Vérifiez la colonne date_debut et le fuseau horaire.";
    } else {
        $reply = "Voici les événements à venir :\n";
        foreach ($events as $event) {
            // Affiche la date brute pour debug
            $reply .= "- {$event->titre} ({$event->date_debut})\n";
        }
    }

    return response()->json(['reply' => $reply]);
}





    // 4️⃣ Utilisation de Gemini comme fallback
    $client = new \GuzzleHttp\Client();
    $apiKey = env('GEMINI_API_KEY');

    try {
        $response = $client->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'headers' => [
                'X-Goog-Api-Key' => $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'contents' => [
                    ['parts' => [['text' => $userMessage]]]
                ]
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Pas de réponse';
    } catch (\Exception $e) {
        \Log::error('Erreur Gemini : '.$e->getMessage());
        $reply = "Désolé, le service Gemini est temporairement indisponible.";
    }

    return response()->json(['reply' => $reply]);
}

}
