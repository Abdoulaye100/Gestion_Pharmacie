@extends('layouts.admin')

@section('title', 'Fournisseurs')

@section('content')
    <section class="container py-4 position-relative">
        <!-- Bande colorée décorative -->
        <div style="position: absolute; top: 0; right: 0; width: 120px; height: 16px; background: linear-gradient(90deg, #0dcaf0 60%, #198754 100%); border-bottom-left-radius: 12px;"></div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-success">Liste des fournisseurs</h1>
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#ajoutFournisseurModal"><i class="bi bi-plus-circle"></i> Ajouter un fournisseur</button>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" action="" method="GET">
                    <input type="text" class="form-control me-2" placeholder="Rechercher un fournisseur...">
                    <button class="btn btn-outline-success" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
        <div class="table-responsive rounded shadow-sm bg-white p-3">
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fournisseurs as $fournisseur)
                        <tr>
                            <td class="fw-semibold">{{ $fournisseur->nom }}</td>
                            <td class="text-muted">{{ $fournisseur->email }}</td>
                            <td>{{ $fournisseur->telephone }}</td>
                            <td>{{ $fournisseur->adresse }}</td>
                            <td>{{ $fournisseur->created_at->format('d/m/Y') }}</td>
                            <td>
                                <!-- Bouton Modifier -->
                                <button class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editFournisseurModal{{ $fournisseur->id }}"><i class="bi bi-pencil"></i></button>
                                <!-- Modal Edition -->
                                <div class="modal fade" id="editFournisseurModal{{ $fournisseur->id }}" tabindex="-1" aria-labelledby="editFournisseurModalLabel{{ $fournisseur->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title" id="editFournisseurModalLabel{{ $fournisseur->id }}"><i class="bi bi-pencil"></i> Modifier le fournisseur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="{{ route('fournisseurs.update', $fournisseur) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body row g-3">
                                                    <div class="col-12">
                                                        <label for="nom{{ $fournisseur->id }}" class="form-label">Nom du fournisseur</label>
                                                        <input type="text" class="form-control" id="nom{{ $fournisseur->id }}" name="nom" value="{{ $fournisseur->nom }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="email{{ $fournisseur->id }}" class="form-label">Email</label>
                                                        <input type="email" class="form-control" id="email{{ $fournisseur->id }}" name="email" value="{{ $fournisseur->email }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="telephone{{ $fournisseur->id }}" class="form-label">Téléphone</label>
                                                        <input type="text" class="form-control" id="telephone{{ $fournisseur->id }}" name="telephone" value="{{ $fournisseur->telephone }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="adresse{{ $fournisseur->id }}" class="form-label">Adresse</label>
                                                        <input type="text" class="form-control" id="adresse{{ $fournisseur->id }}" name="adresse" value="{{ $fournisseur->adresse }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-success">Enregistrer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Bouton Supprimer -->
                                <form action="{{ route('fournisseurs.destroy', $fournisseur) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun fournisseur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal d'ajout de fournisseur -->
        <div class="modal fade" id="ajoutFournisseurModal" tabindex="-1" aria-labelledby="ajoutFournisseurModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="ajoutFournisseurModalLabel"><i class="bi bi-plus-circle"></i> Ajouter un fournisseur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('fournisseurs.store') }}">
                        @csrf
                        <div class="modal-body row g-3">
                            <div class="col-12">
                                <label for="nom" class="form-label">Nom du fournisseur</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-12">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" name="telephone" required>
                            </div>
                            <div class="col-12">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #fournisseur-spinner {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(255,255,255,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
    </style>
    <div id="fournisseur-spinner">
        <div class="spinner-border text-success" style="width: 4rem; height: 4rem;" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('#ajoutFournisseurModal form');
            const spinner = document.getElementById('fournisseur-spinner');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                spinner.style.display = 'flex';
                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                        },
                        body: formData
                    });
                    spinner.style.display = 'none';
                    if (response.ok) {
                        const data = await response.json();
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: data.message || 'Fournisseur ajouté avec succès !',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        setTimeout(() => window.location.reload(), 1200);
                    } else {
                        const error = await response.json();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: error.message || 'Erreur lors de l\'ajout.'
                        });
                    }
                } catch (err) {
                    spinner.style.display = 'none';
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Erreur réseau ou serveur.'
                    });
                }
            });

            // Gestion AJAX pour la modification
            document.querySelectorAll('.modal[id^="editFournisseurModal"] form').forEach(function(editForm) {
                editForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    spinner.style.display = 'flex';
                    const formData = new FormData(editForm);
                    try {
                        const response = await fetch(editForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': editForm.querySelector('input[name=_token]').value
                            },
                            body: formData
                        });
                        spinner.style.display = 'none';
                        if (response.ok) {
                            const data = await response.json();
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: data.message || 'Fournisseur modifié avec succès !',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => window.location.reload(), 1200);
                        } else {
                            const error = await response.json();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: error.message || 'Erreur lors de la modification.'
                            });
                        }
                    } catch (err) {
                        spinner.style.display = 'none';
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur réseau ou serveur.'
                        });
                    }
                });
            });

            // Gestion AJAX pour la suppression
            document.querySelectorAll('form[action*="fournisseurs/"][method="POST"]').forEach(function(deleteForm) {
                if(deleteForm.querySelector('input[name="_method"][value="DELETE"]')) {
                    deleteForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Êtes-vous sûr ?',
                            text: 'Cette action est irréversible !',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#198754',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Oui, supprimer',
                            cancelButtonText: 'Annuler'
                        }).then(async (result) => {
                            if (result.isConfirmed) {
                                spinner.style.display = 'flex';
                                const formData = new FormData(deleteForm);
                                try {
                                    const response = await fetch(deleteForm.action, {
                                        method: 'POST',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': deleteForm.querySelector('input[name=_token]').value
                                        },
                                        body: formData
                                    });
                                    spinner.style.display = 'none';
                                    if (response.ok) {
                                        const data = await response.json();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Supprimé',
                                            text: data.message || 'Fournisseur supprimé avec succès !',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                        setTimeout(() => window.location.reload(), 1200);
                                    } else {
                                        const error = await response.json();
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Erreur',
                                            text: error.message || 'Erreur lors de la suppression.'
                                        });
                                    }
                                } catch (err) {
                                    spinner.style.display = 'none';
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: 'Erreur réseau ou serveur.'
                                    });
                                }
                            }
                        });
                    });
                }
            });

            // Recherche AJAX
            const searchForm = document.querySelector('form.d-flex[action=""]');
            if (searchForm) {
                searchForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    spinner.style.display = 'flex';
                    const q = searchForm.querySelector('input[name="q"], input[type="text"]').value;
                    try {
                        const response = await fetch(`?q=${encodeURIComponent(q)}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        spinner.style.display = 'none';
                        if (response.ok) {
                            const html = await response.text();
                            document.querySelector('table tbody').innerHTML = html;
                        } else {
                            Swal.fire({ icon: 'error', title: 'Erreur', text: 'Erreur lors de la recherche.' });
                        }
                    } catch (err) {
                        spinner.style.display = 'none';
                        Swal.fire({ icon: 'error', title: 'Erreur', text: 'Erreur réseau ou serveur.' });
                    }
                });
            }
        });
    </script>
@endsection 