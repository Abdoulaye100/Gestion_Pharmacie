@extends('layouts.admin')

@section('title', 'Médicaments')

@section('content')
    <section class="container py-4 position-relative">
        <!-- Bande colorée décorative -->
        <div style="position: absolute; top: 0; right: 0; width: 120px; height: 16px; background: linear-gradient(90deg,rgb(65, 216, 90) 60%, #43e97b 100%); border-bottom-left-radius: 12px;"></div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-success">Liste des médicaments</h1>
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#ajoutMedicamentModal"><i class="bi bi-plus-circle"></i> Ajouter un médicament</button>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" id="search-medicament-form" action="{{ route('medicaments.index') }}" method="GET">
                    <input type="text" class="form-control me-2" name="q" placeholder="Rechercher un médicament...">
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
                        <th>Catégorie</th>
                        <th>Fournisseur</th>
                        <th>Prix Achat</th>
                        <th>Prix Vente</th>
                        <th>Quantité</th>
                        <th>Date d'expiration</th>
                        <th>Date d'entrée</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @include('admin.partials.medicaments_tbody', ['medicaments' => $medicaments])
                </tbody>
            </table>
        </div>

        <!-- Modal d'ajout de médicament -->
        <div class="modal fade" id="ajoutMedicamentModal" tabindex="-1" aria-labelledby="ajoutMedicamentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="ajoutMedicamentModalLabel"><i class="bi bi-plus-circle"></i> Ajouter un médicament</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="ajout-medicament-form" method="POST" action="{{ route('medicaments.store') }}">
                        @csrf
                        <div class="modal-body row g-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom du médicament</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="col-md-6">
                                <label for="categorie_id" class="form-label">Catégorie</label>
                                <select class="form-select" id="categorie_id" name="categorie_id" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="fournisseur_id" class="form-label">Fournisseur</label>
                                <select class="form-select" id="fournisseur_id" name="fournisseur_id">
                                    <option value="">Sélectionner...</option>
                                    @foreach($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_expiration" class="form-label">Date de péremption</label>
                                <input type="date" class="form-control" id="date_expiration" name="date_expiration" required>
                            </div>
                            <div class="col-md-6">
                                <label for="prix_achat" class="form-label">Prix d'achat (€)</label>
                                <input type="number" step="0.01" class="form-control" id="prix_achat" name="prix_achat" required>
                            </div>
                            <div class="col-md-6">
                                <label for="prix_vente" class="form-label">Prix de vente (€)</label>
                                <input type="number" step="0.01" class="form-control" id="prix_vente" name="prix_vente" required>
                            </div>
                            <div class="col-md-6">
                                <label for="quantite_stock" class="form-label">Quantité en stock</label>
                                <input type="number" class="form-control" id="quantite_stock" name="quantite_stock" required>
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

        <!-- Modal de modification de médicament -->
        <div class="modal fade" id="editMedicamentModal" tabindex="-1" aria-labelledby="editMedicamentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editMedicamentModalLabel"><i class="bi bi-pencil"></i> Modifier un médicament</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="edit-medicament-form" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body row g-3">
                            <input type="hidden" id="edit_medicament_id" name="id">
                            <div class="col-md-6">
                                <label for="edit_nom" class="form-label">Nom du médicament</label>
                                <input type="text" class="form-control" id="edit_nom" name="nom" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_categorie_id" class="form-label">Catégorie</label>
                                <select class="form-select" id="edit_categorie_id" name="categorie_id" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_fournisseur_id" class="form-label">Fournisseur</label>
                                <select class="form-select" id="edit_fournisseur_id" name="fournisseur_id">
                                    <option value="">Sélectionner...</option>
                                    @foreach($fournisseurs as $fournisseur)
                                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_date_expiration" class="form-label">Date de péremption</label>
                                <input type="date" class="form-control" id="edit_date_expiration" name="date_expiration" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_prix_achat" class="form-label">Prix d'achat (€)</label>
                                <input type="number" step="0.01" class="form-control" id="edit_prix_achat" name="prix_achat" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_prix_vente" class="form-label">Prix de vente (€)</label>
                                <input type="number" step="0.01" class="form-control" id="edit_prix_vente" name="prix_vente" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_quantite_stock" class="form-label">Quantité en stock</label>
                                <input type="number" class="form-control" id="edit_quantite_stock" name="quantite_stock" required>
                            </div>
                            <div class="col-12">
                                <label for="edit_description" class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #medicament-spinner {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(255,255,255,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }
    </style>
    <div id="medicament-spinner">
        <div class="spinner-border text-success" style="width: 4rem; height: 4rem;" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('search-medicament-form');
            const tableBody = document.querySelector('#search-medicament-form').closest('.container').querySelector('table tbody');
            const spinner = document.getElementById('medicament-spinner');
            const editMedicamentModal = new bootstrap.Modal(document.getElementById('editMedicamentModal'));
            const editMedicamentForm = document.getElementById('edit-medicament-form');
            const ajoutMedicamentModal = new bootstrap.Modal(document.getElementById('ajoutMedicamentModal'));
            const ajoutMedicamentForm = document.getElementById('ajout-medicament-form');

            // Fonction pour afficher le spinner
            function showSpinner() {
                spinner.style.display = 'flex';
            }

            // Fonction pour cacher le spinner
            function hideSpinner() {
                spinner.style.display = 'none';
            }

            // Gestion de la recherche AJAX
            if (searchForm) {
                searchForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    showSpinner();
                    const q = searchForm.querySelector('input[name="q"]').value;

                    try {
                        const response = await fetch(`${searchForm.action}?q=${encodeURIComponent(q)}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });

                        hideSpinner();

                        if (response.ok) {
                            const html = await response.text();
                            tableBody.innerHTML = html;
                        } else {
                            const errorData = await response.json();
                            const errorMessage = errorData.message || 'Erreur lors de la recherche.';
                             Swal.fire({ icon: 'error', title: 'Erreur', text: errorMessage });
                        }

                    } catch (err) {
                        hideSpinner();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur réseau ou serveur.'
                        });
                    }
                });
            }

            // Gestion de la soumission du formulaire d'ajout AJAX
            if (ajoutMedicamentForm) {
                ajoutMedicamentForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    showSpinner();

                    const formData = new FormData(ajoutMedicamentForm);
                    const jsonData = Object.fromEntries(formData);

                    try {
                        const response = await fetch(ajoutMedicamentForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(jsonData)
                        });

                        hideSpinner();
                        const result = await response.json();

                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: result.message
                            });

                            // Réinitialiser le formulaire et fermer le modal
                            ajoutMedicamentForm.reset();
                            ajoutMedicamentModal.hide();

                            // Rafraîchir la liste des médicaments après ajout réussi
                            searchForm.dispatchEvent(new Event('submit'));

                        } else {
                            const errorMessage = result.message || 'Erreur lors de l\'ajout.';
                            Swal.fire({ icon: 'error', title: 'Erreur', text: errorMessage });
                        }

                    } catch (err) {
                        hideSpinner();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur réseau ou serveur.'
                        });
                    }
                });
            }

            // Gestion de l'ouverture du modal de modification et pré-remplissage
            tableBody.addEventListener('click', function(e) {
                const editButton = e.target.closest('.edit-medicament-btn');
                if (editButton) {
                    const medicamentId = editButton.dataset.id;
                    const row = editButton.closest('tr');

                    // Récupérer les données de la ligne (simplifié pour l'exemple, idéalement on ferait une requête AJAX pour les données complètes)
                    // Pour l'instant, on récupère les données directement du DOM
                    const nom = row.cells[0].innerText;
                    const description = row.cells[1].innerText;
                    // const categorieNom = row.cells[2].innerText; // On a besoin de l'ID, pas du nom
                    // const fournisseurNom = row.cells[3].innerText; // On a besoin de l'ID, pas du nom
                    const prixAchat = parseFloat(row.cells[4].innerText.replace(' €', ''));
                    const prixVente = parseFloat(row.cells[5].innerText.replace(' €', ''));
                    const quantiteStock = parseInt(row.cells[6].innerText);
                    const dateExpiration = row.cells[7].innerText.split('/').reverse().join('-'); // Convertir DD/MM/YYYY en YYYY-MM-DD

                    // Récupérer les IDs de catégorie et fournisseur depuis les attributs data
                    const categorieId = row.dataset.categorieId;
                    const fournisseurId = row.dataset.fournisseurId;

                    // Pré-remplir le formulaire de modification
                    document.getElementById('edit_medicament_id').value = medicamentId;
                    document.getElementById('edit_nom').value = nom;
                    document.getElementById('edit_description').value = description;
                    document.getElementById('edit_prix_achat').value = prixAchat;
                    document.getElementById('edit_prix_vente').value = prixVente;
                    document.getElementById('edit_quantite_stock').value = quantiteStock;
                    document.getElementById('edit_date_expiration').value = dateExpiration;

                    // Pré-sélectionner les options dans les listes déroulantes
                    if (categorieId) {
                        document.getElementById('edit_categorie_id').value = categorieId;
                    }
                    if (fournisseurId) {
                        document.getElementById('edit_fournisseur_id').value = fournisseurId;
                    }

                    // Mettre à jour l'action du formulaire avec l'ID du médicament
                    editMedicamentForm.action = `/admin/medicaments/${medicamentId}`;

                    // Ouvrir le modal
                    // editMedicamentModal.show(); // Le data-bs-toggle="modal" gère déjà ça
                }
            });

            // Gestion de la soumission du formulaire de modification AJAX
            if (editMedicamentForm) {
                editMedicamentForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    showSpinner();

                    const formData = new FormData(editMedicamentForm);
                    const medicamentId = document.getElementById('edit_medicament_id').value;

                    try {
                        const response = await fetch(`{{ url('admin/medicaments') }}/${medicamentId}`, {
                            method: 'PUT',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(Object.fromEntries(formData))
                        });

                        hideSpinner();
                        const result = await response.json();

                        if (response.ok) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: result.message
                            });

                            // Mettre à jour la ligne du tableau avec les nouvelles données
                            const updatedMedicament = result.medicament;
                            const rowToUpdate = tableBody.querySelector(`tr[data-id="${updatedMedicament.id}"]`);
                            if (rowToUpdate) {
                                // Mettre à jour les cellules de la ligne
                                rowToUpdate.cells[0].innerText = updatedMedicament.nom;
                                rowToUpdate.cells[1].innerText = updatedMedicament.description;
                                rowToUpdate.cells[2].innerText = updatedMedicament.categorie?.nom ?? 'Non défini';
                                rowToUpdate.cells[3].innerText = updatedMedicament.fournisseur?.nom ?? 'Non défini';
                                rowToUpdate.cells[4].innerHTML = `<span class="badge bg-light text-success">${updatedMedicament.prix_achat} €</span>`;
                                rowToUpdate.cells[5].innerHTML = `<span class="badge bg-light text-primary">${updatedMedicament.prix_vente} €</span>`;
                                rowToUpdate.cells[6].innerHTML = `<span class="badge bg-secondary">${updatedMedicament.quantite_stock}</span>`;
                                rowToUpdate.cells[7].innerText = new Date(updatedMedicament.date_expiration).toLocaleDateString('fr-FR');
                            }

                            // Fermer le modal après succès
                            editMedicamentModal.hide();

                        } else {
                            const errorMessage = result.message || 'Erreur lors de la modification.';
                            Swal.fire({ icon: 'error', title: 'Erreur', text: errorMessage });
                        }

                    } catch (err) {
                        hideSpinner();
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Erreur réseau ou serveur.'
                        });
                    }
                });
            }

            // Gestion de la suppression AJAX
            tableBody.addEventListener('click', function(e) {
                const deleteButton = e.target.closest('.delete-medicament-btn');
                if (deleteButton) {
                    const medicamentId = deleteButton.dataset.id;

                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: "Cette action est irréversible !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler'
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            showSpinner();

                            try {
                                const response = await fetch(`{{ url('admin/medicaments') }}/${medicamentId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                });

                                hideSpinner();
                                const result = await response.json();

                                if (response.ok) {
                                    Swal.fire(
                                        'Supprimé !',
                                        result.message,
                                        'success'
                                    );
                                    // Supprimer la ligne du tableau
                                    const rowToDelete = tableBody.querySelector(`tr[data-id="${medicamentId}"]`);
                                    if (rowToDelete) {
                                        rowToDelete.remove();
                                    }
                                } else {
                                    const errorMessage = result.message || 'Erreur lors de la suppression.';
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: errorMessage
                                    });
                                }

                            } catch (err) {
                                hideSpinner();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur',
                                    text: 'Erreur réseau ou serveur.'
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection 