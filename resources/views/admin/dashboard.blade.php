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
    <div class="content-card" id="categories">
        <h1>Gestion des Catégories</h1>

        <!-- Formulaire d'ajout -->
        <div class="form-container">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="d-flex gap-2 w-100">
                @csrf
                <input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie" required>
                <button type="submit" class="btn-add">
                    <i class="fas fa-plus"></i> Ajouter Catégorie
                </button>
            </form>
        </div>

        <!-- Liste des catégories -->
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->id }}</td>
                            <td>{{ $categorie->nom }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Aucune catégorie trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gestion des Utilisateurs -->
    <div class="content-card" id="users">
        <h1>Utilisateurs</h1>
        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom Complet</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->prenom }} {{ $user->nom }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', ['user' => $user->id]) }}" class="btn-edit">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Keep your original JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effects to sidebar items
    document.querySelectorAll('.sidebar .nav-item a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.sidebar .nav-item a').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
</script>
@endsection
