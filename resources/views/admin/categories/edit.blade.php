@extends('admin.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Modifier la catégorie</h2>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la catégorie</label>
            <input
                type="text"
                id="nom"
                name="nom"
                value="{{ old('nom', $category->nom) }}"
                class="form-control @error('nom') is-invalid @enderror"
                required
            >
            @error('nom')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary ms-2">Annuler</a>
    </form>
</div>

<script>
// Exemple simple pour activer la validation Bootstrap 5
(() => {
  'use strict'

  const forms = document.querySelectorAll('.needs-validation')

  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
@endsection
