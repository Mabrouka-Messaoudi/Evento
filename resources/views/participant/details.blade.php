@extends('participant.base')

@section('content')
<div class="container mt-5">

    <div class="row mb-4">
    <!-- Image à gauche -->
    <div class="col-md-4 text-center">
        <img src="{{ asset('storage/' . $event->image) }}"
             class="img-fluid rounded shadow-sm"
             alt="{{ $event->titre }}"
             style="max-height: 300px; object-fit: cover;">
    </div>

    <!-- Informations à droite -->
    <div class="col-md-8">
        <h2 class="d-flex justify-content-between align-items-center">
            {{ $event->titre }}

            <!-- Étoile Favoris -->
            <form action="{{ route('favoris.toggle', $event->id) }}" method="POST" id="favori-form" style="margin:0;">
                @csrf
                <div class="favori-star" title="{{ Auth::user()->favoris->where('event_id', $event->id)->count() ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                    <input type="radio" id="favori" name="favori"
                           {{ Auth::user()->favoris->where('event_id', $event->id)->count() ? 'checked' : '' }} required>
                    <label for="favori">&#9733;</label>
                </div>
            </form>
        </h2>

        <p><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($event->date_debut)->format('d/m/Y H:i') }}</p>
        <p><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($event->date_fin)->format('d/m/Y H:i') }}</p>
        <p><strong>Lieu :</strong> {{ $event->lieu }}</p>
        <p><strong>Capacité :</strong> {{ $event->capacite }} personnes</p>
        <p><strong>Description :</strong></p>
        <p>{{ $event->description }}</p>

        <!-- Bouton Participer -->
        <form action="{{ route('reservations.store', $event->id) }}" method="POST" class="mb-2">
            @csrf
            <button class="btn btn-outline-dark">Participer</button>
        </form>
    </div>
</div>

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
    .favori-star {
    display: inline-flex;
    flex-direction: row-reverse;
}

.favori-star input[type="radio"] {
    display: none;
}

.favori-star label {
    font-size: 2rem;
    color: lightgray;
    cursor: pointer;
    transition: color 0.2s;
}

/* Hover */
.favori-star label:hover,
.favori-star label:hover ~ label {
    color: gold;
}

/* Si en favoris (checked) */
.favori-star input[type="radio"]:checked ~ label {
    color: gold;
}
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const favoriLabel = document.querySelector('.favori-star label');
    const favoriInput = document.querySelector('.favori-star input');
    const favoriForm  = document.getElementById('favori-form');

    favoriLabel.addEventListener('click', function() {
        // Toggle l'état checked pour CSS
        favoriInput.checked = !favoriInput.checked;
        // soumet le formulaire pour ajouter ou retirer le favori
        favoriForm.submit();
    });
});
</script>



@endsection
