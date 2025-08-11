@extends('organisateur.base')
@section('content')
<!-- Section Créer un Événement -->
<div class="row mt-5">
  <div class="col-md-12">
    <h2>Créer un Événement</h2>
    <div class="card p-4">
      <form action="{{ route('organisateur.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <input type="text" name="titre" placeholder="Titre" class="form-control" required>
        </div>
        <div class="mb-3">
          <textarea name="description" placeholder="Description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
          <label for="date_debut">Date de début</label>
          <input type="datetime-local" id="date_debut" name="date_debut" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="date_fin">Date de fin</label>
          <input type="datetime-local" id="date_fin" name="date_fin" class="form-control" required>
        </div>
        <div class="mb-3">
          <input type="text" name="lieu" placeholder="Lieu" class="form-control" required>
        </div>
        <div class="mb-3">
          <input type="number" name="capacite" placeholder="Capacité" class="form-control" required>
        </div>
        <div class="mb-3">
          <input type="file" name="image" class="form-control" required>
        </div>
        <div class="mb-3">
          <select name="categorie_id" class="form-select" required>
            @foreach(\App\Models\Category::all() as $categorie)
              <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
      </form>
    </div>
  </div>
</div>
@endsection
