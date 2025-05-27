@extends('layouts.admin')

@section('title', 'Médicaments')

@section('content')
    <section class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-success">Liste des médicaments</h1>
            <button class="btn btn-success shadow-sm"><i class="bi bi-plus-circle"></i> Ajouter un médicament</button>
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
    </section>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection 