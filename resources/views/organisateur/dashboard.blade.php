@extends('organisateur.base')
@section('content')
@section('content')
<div class="our_room">
  <div class="container">
    <!-- Section Mes Événements -->
    <div class="row">
      <div class="col-md-12">
        <div class="titlepage">
          <h2>Mes Événements</h2>
        </div>
      </div>
    </div>

    @if($events->isEmpty())
      <div class="row">
        <div class="col-md-12">
          <div class="card p-3">
            <p>Aucun événement trouvé.</p>
          </div>
        </div>
      </div>
    @else
      <div class="row">
        @foreach ($events as $event)
          <div class="col-md-4 col-sm-6">
            <div id="serv_hover" class="room card p-3 mb-4">
              <p><strong>Titre:</strong> {{ $event->titre }}</p>

              <div class="room_img mb-3">
                <figure>
                  <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement" class="img-fluid rounded" />
                </figure>
              </div>

              <p><strong>Description:</strong> {{ $event->description }}</p>
              <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}</p>
              <p><strong>Lieu:</strong> {{ $event->lieu }}</p>
              <p><strong>Capacité:</strong> {{ $event->capacite }}</p>
              <p><strong>Statut:</strong>
                @if($event->statut === 'publié')
                  <span class="text-success fw-bold">Publié</span>
                @else
                  <span class="text-warning fw-bold">Brouillon</span>
                @endif
              </p>
              <p><strong>Catégorie ID:</strong> {{ $event->categorie_id }}</p>
              <p><strong>Organisateur ID:</strong> {{ $event->organisateur_id }}</p>

              <form action="{{ route('organisateur.events.edit', $event->id) }}" method="GET" class="mb-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">Modifier</button>
              </form>

              <form action="{{ route('organisateur.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Supprimer cet événement ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm w-100">Supprimer</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif


    <!-- Section Réservations -->


  </div>
</div>
@endsection
