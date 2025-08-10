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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,  $eventId)
    {
    $participantId = auth()->id();
    //$eventId = $request->input('event_id');


    // Avoid duplicate reservation
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
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $reservation = Reservation::findOrFail($id);
    $reservation->statut = $request->statut;
    $reservation->save();

    if ($request->statut == 'accepté') {
        $event = $reservation->event;

        if ($event->capacite > 0) {
            $event->capacite -= 1;
            $event->save();

            // QR content
            $qrContent = "Event: {$event->titre}\nLieu: {$event->lieu}\nDate: {$event->date}";

            // Générer le QR code SVG
            $qrCodeSvg = QrCode::format('svg')->size(200)->generate($qrContent);

            // Sauvegarder le QR code dans storage
            $fileName = 'qrcode_' . time() . '.svg';
            $filePath = 'qrcodes/' . $fileName;
            Storage::disk('public')->put($filePath, $qrCodeSvg);

            // Enregistrer la notification (si besoin)
            Notification::create([
                'reservation_id' => $reservation->id,
                'qr_code_path' => $filePath,
            ]);

            // Envoyer le mail avec la pièce jointe, et passer le titre de l'événement
            Mail::to($reservation->participant->email)
                ->send(new QRCodeMail($filePath, $event->titre));
        } else {
            return back()->with('error', 'No capacity left for this event.');
        }
    }

    return back()->with('success', 'Reservation updated successfully.');
}
public function historique()
{
    // Récupérer l'utilisateur connecté (participant)
    $participant = Auth::user();

    // Récupérer ses réservations avec les infos de l'événement
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
