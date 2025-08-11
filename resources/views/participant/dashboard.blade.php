@extends('participant.base')

@section('content')


<div class="our_room">
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="titlepage">
               <h2>Nos Événements</h2>
               <p>Découvrez nos événements à venir</p>
            </div>
         </div>
      </div>
      <div class="filter-section mb-4">
    <form method="GET" action="{{ route('participant.dashboard') }}">
        <select name="categorie_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- Filtrer par catégorie --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ ($selectedCategory == $category->id) ? 'selected' : '' }}>
                    {{ $category->nom }}
                </option>
            @endforeach
        </select>
        <noscript><button type="submit">Filtrer</button></noscript>
    </form>
</div>
      <div class="row">
         @foreach ($events as $event)
            <div class="col-md-4 col-sm-6">
               <div id="serv_hover" class="room">
                  <div class="room_img">
                     <figure>
                        <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement"/>
                     </figure>
                  </div>
                  <div class="bed_room">
                     <h3>{{ $event->titre }}</h3>
                     <p>{{ Str::limit($event->description, 100) }}</p>
                     <p><strong>Lieu:</strong> {{ $event->lieu }}</p>
                    <p><strong>Date de début:</strong> {{ \Carbon\Carbon::parse($event->date_debut)->format('d/m/Y H:i') }}</p>
                    <p><strong>Date de fin:</strong> {{ \Carbon\Carbon::parse($event->date_fin)->format('d/m/Y H:i') }}</p>
                     <div class="mt-3">
    <a href="{{ route('events.show', $event->id) }}" class="btn btn-dark mb-2">Voir les détails</a>
    <form action="{{ route('reservations.store', $event->id) }}" method="POST">
        @csrf
        <button class="btn btn-outline-dark">Participer</button>
    </form>
</div>

                  </div>
               </div>
            </div>
         @endforeach
      </div>
   </div>
</div>

@endsection
