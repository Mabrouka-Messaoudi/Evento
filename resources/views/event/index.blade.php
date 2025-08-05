@extends('base') {{-- ou ton layout principal --}}

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Liste des événements</h2>

    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Image</th>
                <th>Capacité</th>
                <th>Statut</th>
                <th>Organisateur</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->titre }}</td>
                <td>{{ Str::limit($event->description, 50) }}</td>
                <td>{{ $event->date }}</td>
                <td>{{ $event->lieu }}</td>
                <td>
                    <img src="{{ asset('storage/' . $event->image) }}" width="80" alt="Image de l'événement">
                </td>
                <td>{{ $event->capacite }}</td>
                <td>
                    <span class="badge {{ $event->statut === 'publié' ? 'badge-success' : 'badge-secondary' }}">
                        {{ $event->statut }}
                    </span>
                </td>
                <td>{{ $event->organiser->name ?? '-' }}</td>
                <td>{{ $event->category->nom ?? '-' }}</td>
                <td>
                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-info">Voir</a>
                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet événement ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center"><h6>Aucun événement trouvé.</h6></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
