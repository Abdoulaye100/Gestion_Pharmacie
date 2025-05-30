@extends('layouts.admin')

@section('title', 'Utilisateurs')

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
                    <tr>
                        <td class="fw-semibold">Admin Principal</td>
                        <td>admin@pharmacie.com</td>
                        <td><span class="badge bg-danger">Administrateur</span></td>
                        <td>01/01/2024</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm me-1" disabled>
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" disabled>
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Pharmacien Exemple</td>
                        <td>pharmacien.exemple@pharmacie.com</td>
                        <td><span class="badge bg-primary">Vendeur</span></td>
                         <td>15/01/2024</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm me-1">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Vendeur Exemple</td>
                        <td>vendeur.exemple@pharmacie.com</td>
                        <td><span class="badge bg-info">Vendeur</span></td>
                         <td>20/01/2024</td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm me-1">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
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
                    <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
                        @csrf
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
    </section>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
