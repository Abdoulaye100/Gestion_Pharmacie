@forelse($categories as $categorie)
    <tr>
        <td class="fw-semibold">{{ $categorie->nom }}</td>
        <td class="text-muted">{{ $categorie->description }}</td>
        <td>{{ $categorie->created_at->format('d/m/Y') }}</td>
        <td>
            {{-- Bouton Modifier --}}
            <button class="btn btn-outline-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editCategorieModal{{ $categorie->id }}"><i class="bi bi-pencil"></i></button>

            {{-- Bouton Supprimer --}}
            <form action="{{ route('categories.destroy', $categorie) }}" method="POST" class="d-inline delete-categorie-form" data-id="{{ $categorie->id }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
            </form>

            {{-- Modal Edition (Note: les modals sont souvent mieux générés une seule fois dans la vue principale pour éviter la répétition massive, mais pour coller à la structure précédente et simplifier l'inclusion partielle, nous les laissons ici pour l'instant. Si des problèmes de performance surviennent avec beaucoup de catégories, il faudrait revoir cette partie.) --}}
            <div class="modal fade" id="editCategorieModal{{ $categorie->id }}" tabindex="-1" aria-labelledby="editCategorieModalLabel{{ $categorie->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="editCategorieModalLabel{{ $categorie->id }}"><i class="bi bi-pencil"></i> Modifier la catégorie</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('categories.update', $categorie) }}" data-id="{{ $categorie->id }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body row g-3">
                                <div class="col-12">
                                    <label for="nom{{ $categorie->id }}" class="form-label">Nom de la catégorie</label>
                                    <input type="text" class="form-control" id="nom{{ $categorie->id }}" name="nom" value="{{ $categorie->nom }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="description{{ $categorie->id }}" class="form-label">Description</label>
                                    <textarea class="form-control" id="description{{ $categorie->id }}" name="description" rows="2">{{ $categorie->description }}</textarea>
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
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center text-muted">Aucune catégorie trouvée.</td>
    </tr>
@endforelse 