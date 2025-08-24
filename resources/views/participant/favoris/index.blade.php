@extends('participant.base')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Mes Favoris</h1>

    @if($favoris->isEmpty())
        <div class="alert alert-info">
            Vous n'avez aucun favori pour le moment.
        </div>
    @else
        <div class="row">
            @foreach($favoris as $favori)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($favori->event->image)
                            <img src="{{ asset('storage/' . $favori->event->image) }}"
                                 class="card-img-top"
                                 alt="{{ $favori->event->titre }}"
                                 style="max-height: 200px; object-fit: cover;">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="card-title">{{ $favori->event->titre }}</h5>

                                <!-- Étoile Favoris -->
                                <form action="{{ route('favoris.toggle', $favori->event->id) }}" method="POST" class="m-0 p-0" id="favori-form-{{ $favori->event->id }}">
                                    @csrf
                                    <div class="favori-star" title="Retirer des favoris">
                                        <input type="radio" id="favori-{{ $favori->event->id }}" name="favori" checked required>
                                        <label for="favori-{{ $favori->event->id }}">&#9733;</label>
                                    </div>
                                </form>
                            </div>

                            <p class="card-text text-truncate" style="max-height: 4.5em;">
                                {{ $favori->event->description }}
                            </p>

<p><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($favori->event->date_debut)->format('d/m/Y H:i') }}</p>
        <p><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($favori->event->date_fin)->format('d/m/Y H:i') }}</p>                            <p class="mb-2"><strong>Lieu :</strong> {{ $favori->event->lieu }}</p>

                            <div class="mt-auto">
                                <!-- Tu peux garder le bouton si tu veux -->
                                <!--
                                <form action="{{ route('favoris.destroy', $favori->event->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Retirer
                                    </button>
                                </form>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.favori-star {
    display: inline-flex;
    flex-direction: row-reverse;
}

.favori-star input[type="radio"] {
    display: none;
}

.favori-star label {
    font-size: 1.8rem;
    color: gold;
    cursor: pointer;
    transition: color 0.2s;
}

.favori-star label:hover,
.favori-star label:hover ~ label {
    color: darkorange;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    @foreach($favoris as $favori)
        const label{{ $favori->event->id }} = document.querySelector('#favori-{{ $favori->event->id }} + label');
        const input{{ $favori->event->id }} = document.querySelector('#favori-{{ $favori->event->id }}');
        const form{{ $favori->event->id }}  = document.getElementById('favori-form-{{ $favori->event->id }}');

        label{{ $favori->event->id }}.addEventListener('click', function() {
            input{{ $favori->event->id }}.checked = !input{{ $favori->event->id }}.checked;
            form{{ $favori->event->id }}.submit();
        });
    @endforeach
});
</script>
@endsection
