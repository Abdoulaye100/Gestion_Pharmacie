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
                <form class="d-flex" action="" method="GET">
                    <input type="text" class="form-control me-2" placeholder="Rechercher un médicament...">
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
                    @forelse($medicaments as $medicament)
                        <tr>
                            <td class="fw-semibold">{{ $medicament->nom }}</td>
                            <td class="text-muted" style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $medicament->description }}</td>
                            <td>{{ $medicament->categorie->nom ?? 'Non défini' }}</td>
                            <td>{{ $medicament->fournisseur->nom ?? 'Non défini' }}</td>
                            <td><span class="badge bg-light text-success">{{ $medicament->prix_achat }} €</span></td>
                            <td><span class="badge bg-light text-primary">{{ $medicament->prix_vente }} €</span></td>
                            <td><span class="badge bg-secondary">{{ $medicament->quantite_stock }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($medicament->date_expiration)->format('d/m/Y') }}</td>
                            <td>{{ $medicament->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm me-1"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Aucun médicament trouvé.</td>
                        </tr>
                    @endforelse
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
                    <form method="POST" action="{{ route('medicaments.store') }}">
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
    </section>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection 