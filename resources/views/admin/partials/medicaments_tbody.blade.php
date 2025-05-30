@forelse($medicaments as $medicament)
    <tr data-id="{{ $medicament->id }}" data-categorie-id="{{ $medicament->categorie_id }}" data-fournisseur-id="{{ $medicament->fournisseur_id }}">
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
            <button class="btn btn-outline-primary btn-sm me-1 edit-medicament-btn" data-id="{{ $medicament->id }}" data-bs-toggle="modal" data-bs-target="#editMedicamentModal"><i class="bi bi-pencil"></i></button>
            <button class="btn btn-outline-danger btn-sm delete-medicament-btn" data-id="{{ $medicament->id }}"><i class="bi bi-trash"></i></button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10" class="text-center text-muted">Aucun médicament trouvé.</td>
    </tr>
@endforelse 