@extends('organisateur.base')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Avis pour l'événement : {{ $event->titre }}</h2>

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
</div>
@endsection
