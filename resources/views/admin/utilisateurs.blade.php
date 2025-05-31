@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
    <section class="container py-4 position-relative">
        <!-- Bande colorée décorative -->
        <div style="position: absolute; top: 0; right: 0; width: 120px; height: 16px; background: linear-gradient(90deg,rgb(65, 216, 90) 60%, #43e97b 100%); border-bottom-left-radius: 12px;"></div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-success">Liste des utilisateurs</h1>
            <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#ajoutUtilisateurModal">
                <i class="bi bi-person-plus"></i> Ajouter un utilisateur
            </button>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <form class="d-flex" id="search-utilisateur-form">
                    <input type="text" class="form-control me-2" name="q" placeholder="Rechercher un utilisateur...">
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
                        <th>Rôle</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                     {{-- Static example rows - replace with dynamic data --}}
                    @foreach($users as $user)
                    <tr data-id="{{ $user->id }}" data-role="{{ $user->role }}">
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Administrateur</span>
                            @elseif($user->role == 'vendeur')
                                <span class="badge bg-primary">Vendeur</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td> {{-- Display creation date --}}
                        <td>
                            {{-- Add data attributes for user ID and other info if needed for edit/delete --}}
                            <button class="btn btn-outline-primary btn-sm me-1 edit-utilisateur-btn" data-id="{{ $user->id }}"
                                {{-- Disable edit/delete for admin user (optional, based on logic) --}}
                                @if($user->role == 'admin') disabled @endif
                                >
                                <i class="bi bi-pencil"></i> Modifier
                            </button>
                            <button class="btn btn-outline-danger btn-sm delete-utilisateur-btn" data-id="{{ $user->id }}"
                                 {{-- Disable edit/delete for admin user (optional, based on logic) --}}
                                @if($user->role == 'admin') disabled @endif
                                >
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    {{-- End static example rows --}}
                </tbody>
            </table>
        </div>

        <!-- Modal d'ajout d'utilisateur -->
        <div class="modal fade" id="ajoutUtilisateurModal" tabindex="-1" aria-labelledby="ajoutUtilisateurModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="ajoutUtilisateurModalLabel">
                            <i class="bi bi-person-plus"></i> Ajouter un utilisateur
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-ajout-utilisateur" method="POST" action="{{ route('utilisateurs.store') }}">
                         @csrf {{-- Add CSRF token for future AJAX use --}}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Rôle</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="">Sélectionner un rôle...</option>
                                    <option value="admin">Administrateur</option>
                                    <option value="vendeur">Vendeur</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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

        <!-- Modal de modification d'utilisateur -->
        <div class="modal fade" id="editUtilisateurModal" tabindex="-1" aria-labelledby="editUtilisateurModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editUtilisateurModalLabel">
                            <i class="bi bi-pencil"></i> Modifier l'utilisateur
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form-edit-utilisateur" method="POST">
                        @csrf {{-- Add CSRF token for future AJAX use --}}
                        @method('PUT') {{-- Method spoofing for PUT request --}}
                        <input type="hidden" id="edit-utilisateur-id" name="id">
                        <div class="modal-body">
                             <div class="mb-3">
                                <label for="edit-nom" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="edit-nom" name="nom" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-role" class="form-label">Rôle</label>
                                <select class="form-select" id="edit-role" name="role" required>
                                    <option value="">Sélectionner un rôle...</option>
                                    <option value="admin">Administrateur</option>
                                    <option value="vendeur">Vendeur</option>
                                </select>
                            </div>
                             {{-- Password fields for edit modal (optional, if you allow password change here) --}}
                            {{-- <div class="mb-3">
                                <label for="edit-password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                                <input type="password" class="form-control" id="edit-password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="edit-password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" class="form-control" id="edit-password_confirmation" name="password_confirmation">
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Spinner Element --}}
        <style>
            #utilisateur-spinner {
                display: none; /* Hidden by default */
                position: fixed; /* Fixe la position par rapport à la fenêtre */
                inset: 0; /* Shorthand pour top, right, bottom, left à 0 */
                background: rgba(255,255,255,0.6);
                z-index: 2000;
            }

            #utilisateur-spinner.show-spinner {
                display: flex !important;
                align-items: center;
                justify-content: center;
            }
        </style>
        <div id="utilisateur-spinner">
            <div class="spinner-border text-success" style="width: 4rem; height: 4rem;" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>

    </section>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Placeholder for future JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Future JavaScript for AJAX, modals, etc. will go here.
            const ajoutUtilisateurModal = new bootstrap.Modal(document.getElementById('ajoutUtilisateurModal'));
            const ajoutUtilisateurForm = document.getElementById('form-ajout-utilisateur');
            const tableBody = document.querySelector('.table tbody'); // Assuming the table body is inside an element with class .table
            const spinner = document.getElementById('utilisateur-spinner'); // Spinner pour la page utilisateur

            // Gestion de la recherche
            const searchForm = document.getElementById('search-utilisateur-form');
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const query = this.querySelector('input[name="q"]').value;
                
                // Afficher le spinner
                spinner.classList.add('show-spinner');
                
                fetch(`/admin/utilisateurs?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = data.html;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    Swal.fire('Erreur', 'Une erreur est survenue lors de la recherche', 'error');
                })
                .finally(() => {
                    // Cacher le spinner
                    spinner.classList.remove('show-spinner');
                });
            });

            // Fonction pour afficher le spinner
            function showSpinner() {
                if (spinner) { spinner.classList.add('show-spinner'); }
            }

            // Fonction pour cacher le spinner
            function hideSpinner() {
                 if (spinner) { spinner.classList.remove('show-spinner'); }
            }

            // Event listener for edit and delete buttons on the table body
            tableBody.addEventListener('click', function(e) {
                const editButton = e.target.closest('.edit-utilisateur-btn');
                const deleteButton = e.target.closest('.delete-utilisateur-btn');

                // Handle Edit Button Click
                if (editButton) {
                    const userId = editButton.dataset.id;
                    const row = editButton.closest('tr');

                    // Pré-remplir le modal de modification avec les données de la ligne
                    document.getElementById('edit-utilisateur-id').value = userId;
                    document.getElementById('edit-nom').value = row.cells[0].innerText;
                    document.getElementById('edit-email').value = row.cells[1].innerText;
                    // Pré-sélectionner le rôle (assurez-vous que data-role est défini sur le TR)
                    const role = row.dataset.role;
                    if (role) {
                        document.getElementById('edit-role').value = role;
                    }

                    // Mettre à jour l'action du formulaire avec l'ID de l'utilisateur
                    const editForm = document.getElementById('form-edit-utilisateur');
                    // Utilisez la fonction route() si elle est accessible, sinon construisez l'URL
                    // Assurez-vous que la route 'admin.utilisateurs.update' existe et prend l'ID
                    editForm.action = `/admin/utilisateurs/${userId}`; // Example URL construction

                    // Ouvrir le modal de modification
                    const editModal = new bootstrap.Modal(document.getElementById('editUtilisateurModal'));
                    editModal.show();
                }

                // Handle Delete Button Click
                if (deleteButton) {
                    const userId = deleteButton.dataset.id;

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
                                // Utilisez la fonction route() si elle est accessible, sinon construisez l'URL
                                // Assurez-vous que la route 'admin.utilisateurs.destroy' existe et prend l'ID
                                const response = await fetch(`/admin/utilisateurs/${userId}`, { // Example URL construction
                                    method: 'DELETE',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
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
                                    const rowToDelete = tableBody.querySelector(`tr[data-id="${userId}"]`);
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

            // Gestion de la soumission du formulaire de modification AJAX
             const editUtilisateurForm = document.getElementById('form-edit-utilisateur');
             if (editUtilisateurForm) {
                 editUtilisateurForm.addEventListener('submit', async function(e) {
                     e.preventDefault();
                     showSpinner();

                     const formData = new FormData(editUtilisateurForm);
                     const userId = document.getElementById('edit-utilisateur-id').value; // Get user ID from hidden input
                     const jsonData = Object.fromEntries(formData);
                     // Remove _method and _token as they are handled by headers and fetch method
                     delete jsonData._method; // remove if using PUT method in fetch
                     delete jsonData._token;

                     try {
                         // Use the form's action URL which was set when opening the modal
                         const response = await fetch(editUtilisateurForm.action, {
                             method: 'PUT', // Use PUT method
                             headers: {
                                 'X-Requested-With': 'XMLHttpRequest',
                                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                 'Accept': 'application/json',
                                 'Content-Type': 'application/json' // Send data as JSON
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

                             // Mettre à jour la ligne du tableau avec les nouvelles données
                             const updatedUser = result.user;
                             const rowToUpdate = tableBody.querySelector(`tr[data-id="${updatedUser.id}"]`);
                             if (rowToUpdate) {
                                 rowToUpdate.cells[0].innerText = updatedUser.name;
                                 rowToUpdate.cells[1].innerText = updatedUser.email;
                                 // Mettre à jour le badge de rôle
                                 const roleCell = rowToUpdate.cells[2];
                                 roleCell.innerHTML = ''; // Clear current content
                                 const roleBadge = document.createElement('span');
                                 roleBadge.classList.add('badge');
                                 if (updatedUser.role === 'admin') {
                                     roleBadge.classList.add('bg-danger');
                                     roleBadge.innerText = 'Administrateur';
                                 } else if (updatedUser.role === 'vendeur') {
                                     roleBadge.classList.add('bg-primary');
                                     roleBadge.innerText = 'Vendeur';
                                 }
                                 roleCell.appendChild(roleBadge);
                                 // Mettre à jour l'attribut data-role sur la ligne
                                 rowToUpdate.dataset.role = updatedUser.role;

                                 // La date de création ne change pas, pas besoin de la mettre à jour
                             }

                             // Fermer le modal après succès
                            const editModalInstance = bootstrap.Modal.getInstance(document.getElementById('editUtilisateurModal'));
                            if (editModalInstance) {
                                editModalInstance.hide();
                            }

                         } else {
                             // Gérer les erreurs de validation ou autres erreurs serveur
                             const errorMessage = result.message || 'Erreur lors de la modification.';
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Erreur',
                                  text: errorMessage + (result.errors ? '\n' + Object.values(result.errors).map(err => Array.isArray(err) ? err.join('\n') : err).join('\n') : '')
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
                 });
             }

            // Gestion de la soumission du formulaire d'ajout AJAX
            if (ajoutUtilisateurForm) {
                ajoutUtilisateurForm.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    // Client-side validation for password
                    const passwordField = document.getElementById('password');
                    const passwordConfirmationField = document.getElementById('password_confirmation');
                    const password = passwordField.value;
                    const passwordConfirmation = passwordConfirmationField.value;

                    if (password.length < 8) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur de validation',
                            text: 'Le mot de passe doit contenir au moins 8 caractères.'
                        });
                        return;
                    }

                    if (password !== passwordConfirmation) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur de validation',
                            text: 'Les mots de passe ne correspondent pas.'
                        });
                        return;
                    }
                    // End client-side validation

                    showSpinner();

                    const formData = new FormData(ajoutUtilisateurForm);
                    const jsonData = Object.fromEntries(formData);

                    try {
                        const response = await fetch(ajoutUtilisateurForm.action, {
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
                            ajoutUtilisateurForm.reset();
                            ajoutUtilisateurModal.hide();

                            // Rafraîchir la liste des utilisateurs après ajout réussi
                            // Pour l'instant, on peut simplement recharger la page ou implémenter
                            // un rafraîchissement AJAX du tableau plus tard.
                            // window.location.reload(); // Option simple: recharger la page
                            // Ou mieux : faire une requête AJAX pour obtenir le nouveau contenu du tableau
                            refreshUserTable(); // Appel d'une fonction pour rafraîchir le tableau

                        } else {
                            // Gérer les erreurs de validation ou autres erreurs serveur
                            const errorMessage = result.message || 'Erreur lors de l\'ajout.';
                             Swal.fire({
                                 icon: 'error',
                                 title: 'Erreur',
                                 text: errorMessage + (result.errors ? '\n' + Object.values(result.errors).map(err => Array.isArray(err) ? err.join('\n') : err).join('\n') : '')
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
                });
            }

            // Fonction pour rafraîchir le tableau des utilisateurs via AJAX
            async function refreshUserTable() {
                 showSpinner();
                 try {
                     const response = await fetch("{{ route('utilisateurs.index') }}", {
                         headers: {
                             'X-Requested-With': 'XMLHttpRequest'
                         }
                     });

                     hideSpinner();

                     if (response.ok) {
                         const html = await response.text();
                         // Trouver le tbody de la table et mettre à jour son contenu
                         const parser = new DOMParser();
                         const doc = parser.parseFromString(html, 'text/html');
                         const newTableBody = doc.querySelector('tbody');
                         if (newTableBody && tableBody) {
                             tableBody.innerHTML = newTableBody.innerHTML;
                         }
                     } else {
                         const errorData = await response.json();
                         const errorMessage = errorData.message || 'Erreur lors du rafraîchissement du tableau.';
                         Swal.fire({ icon: 'error', title: 'Erreur', text: errorMessage });
                     }
                 } catch (err) {
                     hideSpinner();
                     Swal.fire({
                         icon: 'error',
                         title: 'Erreur',
                         text: 'Erreur réseau ou serveur lors du rafraîchissement du tableau.'
                     });
                 }
            }

        });
    </script>
@endsection
