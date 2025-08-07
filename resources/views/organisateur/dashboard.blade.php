@extends('organisateur.base')
@section('content')
    <!-- Main content with padding to avoid sidebar and navbar overlap -->
    <div class="main-content" style="margin-left: 250px; padding-top: 64px;">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
            <!-- Events -->
            <section id="events" class="section">
                <h3>Mes Événements</h3>
                @if($events->isEmpty())
                    <div class="card">
                        <p>Aucun événement trouvé.</p>
                    </div>
                @else

    @foreach ($events as $event)
        <div class="card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; width: 300px; min-width: 300px; flex-shrink: 0;">
            <p><strong>Titre:</strong> {{ $event->titre }}</p>

            {{-- Image --}}
            <img src="{{ asset('storage/' . $event->image) }}" alt="Image de l'événement"
                 style="width: 100%; height: auto; border-radius: 5px; margin-bottom: 10px;">

            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}</p>
            <p><strong>Lieu:</strong> {{ $event->lieu }}</p>
            <p><strong>Capacité:</strong> {{ $event->capacite }}</p>
            <p><strong>Statut:</strong>
                @if($event->statut === 'publié')
                    <span style="color: green; font-weight: bold;">Publié</span>
                @else
                    <span style="color: orange; font-weight: bold;">Brouillon</span>
                @endif
            </p>
            <p><strong>Catégorie ID:</strong> {{ $event->categorie_id }}</p>
            <p><strong>Organisateur ID:</strong> {{ $event->organisateur_id }}</p>


                            <form action="{{ route('organisateur.events.edit', $event->id) }}" method="GET">
                                <button type="submit">Modifier</button>
                            </form>

                            <form action="{{ route('organisateur.events.destroy', $event->id) }}" method="POST"
                                  onsubmit="return confirm('Supprimer cet événement ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Supprimer</button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </section>

            <!-- Create Event -->
            <section id="create" class="section">
                <h3>Créer un Événement</h3>
                <div class="card">
                    <form action="{{ route('organisateur.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="titre" placeholder="Titre" required>
                        <textarea name="description" placeholder="Description" required></textarea>
                        <input type="datetime-local" name="date" required>
                        <input type="text" name="lieu" placeholder="Lieu" required>
                        <input type="number" name="capacite" placeholder="Capacité" required>
                        <select name="statut" required>
                            <option value="publié">Publié</option>
                            <option value="brouillon">Brouillon</option>
                        </select>
                        <input type="file" name="image" required>
                        <select name="categorie_id" required>
                            @foreach(\App\Models\Category::all() as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Créer</button>
                    </form>
                </div>
            </section>

            <!-- Reservations -->
            <section id="reservations" class="section">
                <h3>Réservations</h3>
                <div class="card">

                    <p><strong>Événement:</strong> Conférence Web</p>
                    <div class="reservation-actions">
                        <button>Accepter et envoyer QR</button>
                        <button>Refuser</button>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

</html>

@endsection
