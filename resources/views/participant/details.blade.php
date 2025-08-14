@extends('participant.base')

@section('content')
<div class="container mt-5">

    <!-- Titre -->
    <h2 class="mb-4 text-center">{{ $event->titre }}</h2>

    <!-- Image de l'événement -->
    <div class="text-center mb-4">
        <img src="{{ asset('storage/' . $event->image) }}"
             class="img-fluid rounded shadow-sm"
             alt="{{ $event->titre }}"
             style="max-height: 400px; object-fit: cover;">
    </div>

    <!-- Informations principales -->
    <div class="card p-4 shadow-sm">
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y H:i') }}</p>
        <p><strong>Lieu :</strong> {{ $event->lieu }}</p>
        <p><strong>Capacité :</strong> {{ $event->capacite }} personnes</p>
        <p><strong>Description :</strong></p>
        <p>{{ $event->description }}</p>

        <!-- Bouton participer -->
        <form action="{{ route('reservations.store', $event->id) }}" method="POST" class="mb-4">
            @csrf
            <button class="btn btn-outline-dark">Participer</button>
        </form>

        <!-- Formulaire Avis -->
<h5 class="mt-4">Donner votre avis</h5>
<form action="{{ route('avis.store', $event->id) }}" method="POST">
    @csrf
    <!-- Étoiles -->
    <div class="mb-3 stars">
        @for ($i = 5; $i >= 1; $i--)
            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
            <label for="star{{ $i }}">&#9733;</label>
        @endfor
    </div>

    <!-- Commentaire -->
    <div class="mb-3">
        <textarea name="comment" class="form-control" placeholder="Votre commentaire..." rows="3" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Envoyer l'avis</button>
</form>
<!-- Liste des avis -->
<h5 class="mt-5">Avis des participants</h5>

@if($event->avis->count() > 0)
    @foreach($event->avis as $avis)
        <div class="border rounded p-3 mb-3">
            <!-- Affichage des étoiles -->
            <div>
                @for ($i = 1; $i <= 5; $i++)
                    @if($i <= $avis->rating)
                        <span style="color: gold; font-size: 1.2rem;">&#9733;</span>
                    @else
                        <span style="color: lightgray; font-size: 1.2rem;">&#9733;</span>
                    @endif
                @endfor
            </div>
            <p class="mb-1">
                <strong>{{ $avis->user->nom ?? '' }} {{ $avis->user->prenom ?? '' }}</strong>
            </p>
            <p class="mb-0">{{ $avis->comment }}</p>
            <small class="text-muted">Posté le {{ $avis->created_at->format('d/m/Y à H:i') }}</small>
        </div>
    @endforeach
@else
    <p class="text-muted">Aucun avis pour cet événement pour le moment.</p>
@endif


<style>
    /* Conteneur étoiles */
    .stars {
        display: flex;
        flex-direction: row-reverse; /* pour que hover remplisse à gauche */
        justify-content: flex-end;
        gap: 5px;
    }

    .stars input[type="radio"] {
        display: none;
    }

    .stars label {
        font-size: 2rem;
        color: lightgray;
        cursor: pointer;
        transition: color 0.2s;
    }

    /* Hover : toutes celles à gauche */
    .stars label:hover,
    .stars label:hover ~ label {
        color: gold;
    }

    /* Après sélection */
    .stars input[type="radio"]:checked ~ label {
        color: gold;
    }
</style>

@endsection
