@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="w-100" style="max-width: 500px;">
        <h2 class="mb-4 text-center">Modifier mon profil</h2>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="{{ old('prenom', auth()->user()->prenom) }}" required>
            </div>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', auth()->user()->nom) }}" required>
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" class="form-control" value="{{ old('telephone', auth()->user()->telephone) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" id="adresse" name="adresse" class="form-control" value="{{ old('adresse', auth()->user()->adresse) }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
        </form>

        <hr class="my-4">

        <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">Supprimer mon compte</button>
        </form>
    </div>
</div>
@endsection
