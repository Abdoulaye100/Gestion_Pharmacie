@extends('layouts.admin')

@section('title', 'Catégories')

@section('content')
    <section class="container py-4 position-relative">
        <!-- Bande colorée décorative -->
        <div style="position: absolute; top: 0; right: 0; width: 120px; height: 16px; background: linear-gradient(90deg, #ffc107 60%, #ff9800 100%); border-bottom-left-radius: 12px;"></div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-success">Liste des catégories</h1>
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#ajoutCategorieModal"><i class="bi bi-plus-circle"></i> Ajouter une catégorie</button>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" id="search-categorie-form" action="{{ route('categories.index') }}" method="GET">
                    <input type="text" class="form-control me-2" name="q" placeholder="Rechercher une catégorie...">
                    <button class="btn btn-outline-success" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
        <div class="table-responsive rounded shadow-sm bg-white p-3">
            <table class="table table-hover align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin.partials.categories_tbody', ['categories' => $categories])
                </tbody>
            </table>
        </div>

        <!-- Modal d'ajout de catégorie -->
        <div class="modal fade" id="ajoutCategorieModal" tabindex="-1" aria-labelledby="ajoutCategorieModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="ajoutCategorieModalLabel"><i class="bi bi-plus-circle"></i> Ajouter une catégorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="modal-body row g-3">
                            <div class="col-12">
                                <label for="nom" class="form-label">Nom de la catégorie</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2"></textarea>
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

        {{-- Modals de modification (ils sont maintenant générés dans la boucle du tableau via la vue partielle) --}}
    </section>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #categorie-spinner {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(255,255,255,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
    </style>
    <div id="categorie-spinner">
        <div class="spinner-border text-success" style="width: 4rem; height: 4rem;" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ajoutForm = document.querySelector('#ajoutCategorieModal form');
            const spinner = document.getElementById('categorie-spinner');
            const searchForm = document.getElementById('search-categorie-form');
            const tableBody = document.querySelector('#search-categorie-form').closest('.container').querySelector('table tbody');

            // 🔄 AJOUT CATEGORIE
            if (ajoutForm) {
                ajoutForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    spinner.style.display = 'flex';
                    const formData = new FormData(ajoutForm);

                    try {
                        const response = await fetch(ajoutForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                            },
                            body: formData
                        });

                        spinner.style.display = 'none';
                        const data = await response.json();

                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: data.message || 'Catégorie ajoutée avec succès !',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => window.location.reload(), 1200);
                        } else {
                            const errorData = await response.json();
                            const errorMessage = errorData.message || 'Erreur lors de l\'ajout.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: errorMessage
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
            }

            // 🔄 MODIFICATION CATEGORIE
            document.querySelectorAll('.modal[id^="editCategorieModal"] form').forEach(function(editForm) {
                editForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    spinner.style.display = 'flex';
                    const formData = new FormData(editForm);
                    const id = editForm.dataset.id;

                    try {
                        const response = await fetch(`/admin/categories/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': editForm.querySelector('input[name=_token]').value
                            },
                            body: formData
                        });

                        spinner.style.display = 'none';
                        const data = await response.json();

                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: data.message || 'Catégorie modifiée avec succès !',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => window.location.reload(), 1200);
                        } else {
                            const errorData = await response.json();
                            const errorMessage = errorData.message || 'Erreur lors de la modification.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: errorMessage
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

            // ❌ SUPPRESSION CATEGORIE
            document.querySelectorAll('.delete-categorie-form').forEach(function(deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: 'Cette action est irréversible !',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            spinner.style.display = 'flex';
                            const id = deleteForm.dataset.id;

                            try {
                                const response = await fetch(`/admin/categories/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': deleteForm.querySelector('input[name=_token]').value
                                    }
                                });

                                spinner.style.display = 'none';
                                const data = await response.json();

                                if (response.ok) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Supprimé !',
                                        text: data.message || 'Catégorie supprimée avec succès !',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    setTimeout(() => window.location.reload(), 1200);
                                } else {
                                    const errorData = await response.json();
                                    const errorMessage = errorData.message || 'Erreur lors de la suppression.';
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: errorMessage
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
            });

            // 🔍 RECHERCHE CATEGORIE
            if (searchForm) {
                searchForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    spinner.style.display = 'flex';
                    const q = searchForm.querySelector('input[name="q"], input[type="text"]').value;

                    try {
                        const response = await fetch(`${searchForm.action}?q=${encodeURIComponent(q)}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });

                        spinner.style.display = 'none';

                        if (response.ok) {
                            const html = await response.text();
                            tableBody.innerHTML = html;
                        } else {
                            Swal.fire({ icon: 'error', title: 'Erreur', text: 'Erreur lors de la recherche.' });
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
            }
        });
    </script>
@endsection
