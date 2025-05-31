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
    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
    <td>
        <button class="btn btn-outline-primary btn-sm me-1 edit-utilisateur-btn" data-id="{{ $user->id }}"
            @if($user->role == 'admin') disabled @endif>
            <i class="bi bi-pencil"></i> Modifier
        </button>
        <button class="btn btn-outline-danger btn-sm delete-utilisateur-btn" data-id="{{ $user->id }}"
            @if($user->role == 'admin') disabled @endif>
            <i class="bi bi-trash"></i> Supprimer
        </button>
    </td>
</tr>
@endforeach 