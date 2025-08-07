@extends('admin.admin')
@section('title', 'Dashboard')
@section('content')

    <div class="main-content">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <!-- Categories CRUD Section -->
        <section id="categories" class="section">
            <h3>Gestion des Catégories</h3>
            <div class="card">
                <!-- Create Category Form -->
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <input type="text" name="nom" placeholder="Nom de la catégorie" required />
                    <button type="submit">Ajouter Catégorie</button>
                </form>
            </div>

            <!-- Categories List -->
            <div class="card">
    @if($categories->isEmpty())
        <p>Aucune catégorie trouvée.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom Complet</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $categorie)
                    <tr>
                        <td>{{ $categorie->id }}</td>
                        <td>{{ $categorie->nom }}</td>
                        <td>
                                <a href="{{ route('admin.categories.edit', $categorie->id) }}" class="btn-edit">Modifier</a>

                        </td>
                        <td class="actions">
                            <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>



        <!-- Users Section -->
        <section id="users" class="section">
            <h3>Utilisateurs</h3>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom Complet</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->prenom }} {{ $user->nom }}</td>

                            <td class="actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn-read">Voir</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($users->isEmpty())
                    <p>Aucun utilisateur trouvé.</p>
                @endif
            </div>
        </section>

@endsection
