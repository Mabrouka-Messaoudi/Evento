@extends('admin.admin') {{-- Or your main admin layout --}}

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Détails de l'utilisateur</h1>

    <div class="bg-white shadow rounded p-6 max-w-md">
        <p><strong>ID :</strong> {{ $user->id }}</p>
        <p><strong>Prénom :</strong> {{ $user->prenom }}</p>
        <p><strong>Nom :</strong> {{ $user->nom }}</p>


        <a href="{{ route('admin.users.show') }}" class="inline-block mt-4 text-blue-600 hover:underline">Retour à la liste</a>
    </div>
</div>
@endsection
