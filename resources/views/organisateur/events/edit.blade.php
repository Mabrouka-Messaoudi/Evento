@extends('organisateur.base')

@section('content')
    <div class="container mt-5">
        <h2>Modifier l'événement</h2>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit form -->
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre', $event->titre) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="datetime-local" name="date" class="form-control" value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="mb-3">
                <label for="lieu" class="form-label">Lieu</label>
                <input type="text" name="lieu" class="form-control" value="{{ old('lieu', $event->lieu) }}" required>
            </div>

            <div class="mb-3">
                <label for="capacite" class="form-label">Capacité</label>
                <input type="number" name="capacite" class="form-control" value="{{ old('capacite', $event->capacite) }}" required>
            </div>



            <div class="mb-3">
                <label for="image" class="form-label">Image (laisser vide pour garder l'actuelle)</label>
                <input type="file" name="image" class="form-control">
                @if($event->image)
                    <p>Image actuelle:</p>
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" width="200">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('organisateur.dashboard') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
@endsection
