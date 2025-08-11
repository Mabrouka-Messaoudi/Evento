@extends('admin.admin')
@section('title', 'Dashboard')

@section('content')
<div class="main-content">
    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Gestion des Catégories -->
    <section id="categories" class="mb-5">
        <h3 class="mb-3">Gestion des Catégories</h3>

        <!-- Formulaire d'ajout -->
        <div class="card p-3 mb-4 shadow-sm">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="row g-2 align-items-center">
                @csrf
                <div class="col-md-8">
                    <input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Ajouter Catégorie</button>
                </div>
            </form>
        </div>

        <!-- Liste des catégories -->
        <div class="card p-3 shadow-sm">
            @if($categories->isEmpty())
                <p class="text-muted m-0">Aucune catégorie trouvée.</p>
            @else
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th class="text-center" colspan="2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $categorie)
                            <tr>
                                <td>{{ $categorie->id }}</td>
                                <td>{{ $categorie->nom }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>

    <!-- Gestion des Utilisateurs -->
    <section id="users">
        <h3 class="mb-3">Utilisateurs</h3>
        <div class="card p-3 shadow-sm">
            @if($users->isEmpty())
                <p class="text-muted m-0">Aucun utilisateur trouvé.</p>
            @else
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom Complet</th>
                            <th>Email</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->prenom }} {{ $user->nom }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                <a href="{{ route('admin.users.show', ['user' => $user->id]) }}" class="btn btn-sm btn-info">Voir</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</div>
@endsection
