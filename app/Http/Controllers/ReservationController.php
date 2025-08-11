<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Mail\QRCodeMail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $organisateurId = Auth::id();

    // Récupérer uniquement les réservations liées aux événements de cet organisateur
    $reservations = Reservation::whereHas('event', function ($query) use ($organisateurId) {
        $query->where('organisateur_id', $organisateurId);
    })->get();

    return view('organisateur.reservations.gestion', compact('reservations'));


}



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,  $eventId)
    {
    $participantId = auth()->id();


    $existing = Reservation::where('event_id', $eventId)
        ->where('participant_id', $participantId)
        ->first();

    if ($existing) {
        return back()->with('error', 'You have already requested to participate.');
    }

    Reservation::create([
        'event_id' => $eventId,
        'participant_id' => $participantId,
    ]);

    return back()->with('success', 'Participation request sent!');
}





    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $reservation = Reservation::findOrFail($id);

    // On vérifie si le statut demandé est "accepté"
    if ($request->statut == 'accepté') {
        $event = $reservation->event;

        // On vérifie si la capacité est > 1 (donc au moins 1 place dispo après acceptation)
        if ($event->capacite > 1) {
            // On met à jour le statut de la réservation
            $reservation->statut = $request->statut;
            $reservation->save();

            // On diminue la capacité d'une place
            $event->capacite -= 1;
            $event->save();

            // Contenu du QR code avec date début et date fin
            $qrContent = "Event: {$event->titre}\nLieu: {$event->lieu}\nDate début: {$event->date_debut}\nDate fin: {$event->date_fin}";

            // Génération du QR code SVG
            $qrCodeSvg = QrCode::format('svg')->size(200)->generate($qrContent);

            // Sauvegarde du QR code dans storage/public/qrcodes
            $fileName = 'qrcode_' . time() . '.svg';
            $filePath = 'qrcodes/' . $fileName;
            Storage::disk('public')->put($filePath, $qrCodeSvg);

            Notification::create([
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->participant_id,
                'qr_code_path' => $filePath,
                'message' => "Votre réservation pour l'événement '{$event->titre}' a été acceptée.",
            ]);

            Mail::to($reservation->participant->email)
                ->send(new QRCodeMail($filePath, $event->titre));
        } else {
            return back()->with('error', 'Pas assez de places disponibles pour accepter cette réservation.');
        }
    } else {
        // Si le statut n'est pas "accepté", on met juste à jour le statut sans modifier la capacité
        $reservation->statut = $request->statut;
        $reservation->save();
    }

    return back()->with('success', 'Statut de réservation mis à jour.');
}

public function historique()
{
    $participant = Auth::user();

    $reservations = $participant->reservations()->with('event')->get();

    return view('participant.reservations.historique', compact('reservations'));
}
public function destroy($id)
{
    $reservation = Reservation::findOrFail($id);

    // Vérifier que l'utilisateur est bien le propriétaire de la réservation
    if ($reservation->participant_id !== auth()->id()) {
        abort(403, 'Non autorisé.');
    }

    // Modifier le statut au lieu de supprimer si tu veux garder l'historique
    $reservation->statut = 'annulé';
    $reservation->save();



    return redirect()->route('participant.reservations.historique')->with('success', 'Réservation annulée avec succès.');
}



}
