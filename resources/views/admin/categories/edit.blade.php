@extends('admin.admin')

@section('content')
    <h2>Modifier la catégorie</h2>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nom">Nom de la catégorie</label>
        <input type="text" id="nom" name="nom" value="{{ old('nom', $category->nom) }}" required>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection
