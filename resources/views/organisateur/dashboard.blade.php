@extends('organisateur.base')
@section('content')
<style>
/* Styles personnalisés pour les boutons */
.btn-custom-red {
    background-color: #e74c3c; /* rouge vif */
    color: #fff;
    border: 2px solid #c0392b;
    font-weight: bold;
    border-radius: 12px; /* arrondi */
    padding: 10px 15px;
    transition: 0.3s;
}

.btn-custom-red:hover {
    background-color: #c0392b;
    color: #fff;
}

.btn-custom-black {
    background-color: #2c3e50; /* noir/gris foncé */
    color: #fff;
    border: 2px solid #000;
    font-weight: bold;
    border-radius: 12px;
    padding: 10px 15px;
    transition: 0.3s;
}

.btn-custom-black:hover {
    background-color: #000;
    color: #fff;
}

.btn-custom-white {
    background-color: #fff; /* blanc */
    color: #2c3e50;
    border: 2px solid #2c3e50;
    font-weight: bold;
    border-radius: 12px;
    padding: 10px 15px;
    transition: 0.3s;
}

.btn-custom-white:hover {
    background-color: #2c3e50;
    color: #fff;
}

/* Conteneur pour espacer les boutons */
.btn-container {
    display: flex;
    flex-direction: column;
    gap: 15px; /* espace entre les boutons */
    max-width: 250px; /* largeur uniforme */
}
</style>
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
              <p>
                <strong>Date début:</strong> {{ \Carbon\Carbon::parse($event->date_debut)->format('d M Y H:i') }}<br>
                <strong>Date fin:</strong> {{ \Carbon\Carbon::parse($event->date_fin)->format('d M Y H:i') }}
              </p>
              <p><strong>Lieu:</strong> {{ $event->lieu }}</p>
              <p><strong>Capacité:</strong> {{ $event->capacite }}</p>
              <p><strong>Catégorie:</strong> {{ $event->categorie->nom ?? 'N/A' }}</p>

              <div class="btn-container">
    <form action="{{ route('organisateur.events.edit', $event->id) }}" method="GET">
        <button type="submit" class="btn btn-custom-white btn-sm w-100">Modifier</button>
    </form>

    <form action="{{ route('organisateur.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Supprimer cet événement ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-custom-red btn-sm w-100">Supprimer</button>
    </form>

    <a href="{{ route('events.show', ['id' => $event->id, 'viewType' => 'organisateur']) }}" class="btn btn-custom-black btn-sm w-100">
        Voir les avis
    </a>
</div>

            </div>
          </div>
        @endforeach
      </div>
    @endif

    <!-- Section Réservations -->

  </div>
</div>
@endsection
