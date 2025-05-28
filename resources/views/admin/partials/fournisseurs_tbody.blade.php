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
                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Supprimer ce fournisseur ?')"><i class="bi bi-trash"></i></button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted">Aucun fournisseur trouvé.</td>
    </tr>
@endforelse 