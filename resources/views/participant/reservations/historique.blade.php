@extends('participant.base')

@section('content')
<div class="container">
    <h2>Mes réservations</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($reservations->isEmpty())
        <p>Vous n'avez aucune réservation pour le moment.</p>
    @else

        @php
            // Vérifier si au moins une réservation est "en attente"
            $hasPending = $reservations->contains(function($reservation) {
                return $reservation->statut === 'en_attente';
            });
        @endphp

        <table class="table">
            <thead>
                <tr>
                    <th>Événement</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Statut</th>
                    <th>QR Code</th>
                    @if($hasPending)
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->event->titre }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->event->date)->format('d/m/Y H:i') }}</td>
                        <td>{{ $reservation->event->lieu }}</td>
                        <td>{{ $reservation->statut }}</td>
                        <td>
                            @if($reservation->notification && $reservation->notification->qr_code_path)
                                <img src="{{ asset('storage/' . $reservation->notification->qr_code_path) }}" alt="QR Code" width="100" height="100" />
                            @else
                                <span>Pas de QR code</span>
                            @endif
                        </td>

                        {{-- Colonne Action affichée uniquement si $hasPending --}}
                        @if($hasPending)
                            <td>
                                @if($reservation->statut === 'en_attente')
                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                                    </form>
                                @else
                                    {{-- Pour les autres statuts on ne met rien (cellule vide) --}}
                                @endif
                            </td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>
@endsection
