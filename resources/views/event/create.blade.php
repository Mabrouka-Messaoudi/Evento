@extends('base') {{-- Assumes your layout file is in resources/views/base.blade.php --}}

@section('content')


    {{-- Show validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" value="{{ old('titre') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="date">Date et Heure</label>
            <input type="datetime-local" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
        </div>

        <div class="form-group">
            <label for="lieu">Lieu</label>
            <input type="text" name="lieu" id="lieu" class="form-control" value="{{ old('lieu') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Image (upload)</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>

        <div class="form-group">
            <label for="capacite">Capacité</label>
            <input type="number" name="capacite" id="capacite" class="form-control" value="{{ old('capacite') }}" required>
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" id="statut" class="form-control">
                <option value="brouillon" {{ old('statut') === 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                <option value="publié" {{ old('statut') === 'publié' ? 'selected' : '' }}>Publié</option>
            </select>
        </div>



        <button type="submit" class="btn btn-primary">Créer l'événement</button>
    </form>
</div>
@endsection
