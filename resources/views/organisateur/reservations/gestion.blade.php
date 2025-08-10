@extends('organisateur.base')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Gestion des Réservations</h2>

    @if($reservations->isEmpty())
        <div class="alert alert-info">
            Aucune réservation pour le moment.
        </div>
    @else
        <div class="card shadow-sm p-3">
            <div class="d-flex flex-wrap gap-3">
                @foreach ($reservations as $reservation)
                    <div class="border rounded bg-light p-3 flex-fill" style="min-width: 250px; max-width: 300px;">
                        <h5 class="mb-2">{{ $reservation->event->titre }}</h5>
                        <p class="mb-1"><strong>Participant :</strong> {{ $reservation->participant->name }}</p>
                        <p class="mb-1"><strong>Statut :</strong>
                            <span class="badge
                                @if($reservation->statut === 'accepté') bg-success
                                @elseif($reservation->statut === 'refusé') bg-danger
                                @else bg-warning text-dark
                                @endif">
                                {{ ucfirst($reservation->statut) }}
                            </span>
                        </p>

                        @if($reservation->statut === 'en_attente')
                        <form method="POST" action="{{ route('reservation.update', $reservation->id) }}">
                            @csrf
                            @method('PATCH')
                            <button name="statut" value="accepté" class="btn btn-success btn-sm me-2">Accepter</button>
                            <button name="statut" value="refusé" class="btn btn-danger btn-sm me-2">Refuser</button>
                        </form>
                    @endif

                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
