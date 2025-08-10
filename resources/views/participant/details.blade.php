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
        <form action="{{ route('reservations.store', $event->id) }}" method="POST">
        @csrf
        <button class="btn btn-outline-dark">Participer</button>
    </form>
    </div>

</div>
@endsection
