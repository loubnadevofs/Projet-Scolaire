@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête avec titre et statistiques -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-3 mb-md-0">
                    <h1 class="h3 mb-2 text-gray-800">
                        <i class="fas fa-book-open me-2 text-primary"></i>
                        Gestion des Matières
                    </h1>
                    <p class="text-muted mb-0">Gérez les matières et leurs coefficients</p>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-info fs-6 px-3 py-2">
                        <i class="fas fa-list me-1"></i>
                        {{ $matieres->count() }} matières
                    </span>
                    <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-plus me-2"></i>
                        Ajouter une Matière
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Barre de recherche et filtres -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ request()->url() }}" class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">
                        <i class="fas fa-search me-1"></i>
                        Rechercher une matière
                    </label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Tapez le nom de la matière..."
                               autocomplete="off">
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="sort_by" class="form-label">
                        <i class="fas fa-sort me-1"></i>
                        Trier par
                    </label>
                    <select class="form-select form-select-lg" name="sort_by" id="sort_by">
                        <option value="nomM" {{ request('sort_by') == 'nomM' ? 'selected' : '' }}>Nom</option>
                        <option value="coefficient" {{ request('sort_by') == 'coefficient' ? 'selected' : '' }}>Coefficient</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="btn-group w-100" role="group">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ request()->url() }}" class="btn btn-outline-secondary btn-lg" title="Réinitialiser">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des matières -->
    <div class="card shadow">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>
                    Liste des Matières
                </h5>
                @if(request('search'))
                    <small class="opacity-75">
                        Résultats pour: "{{ request('search') }}"
                    </small>
                @endif
            </div>
        </div>
        
        <div class="card-body p-0">
            @if ($matieres->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-book-open fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Aucune matière trouvée</h5>
                    <p class="text-muted mb-3">
                        @if(request('search'))
                            Aucune matière ne correspond à votre recherche "{{ request('search') }}".
                        @else
                            Aucune matière n'a été ajoutée pour le moment.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        @if(request('search'))
                            <a href="{{ request()->url() }}" class="btn btn-outline-primary">
                                <i class="fas fa-undo me-1"></i>
                                Afficher toutes les matières
                            </a>
                        @endif
                        <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            Ajouter la première matière
                        </a>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%">#</th>
                                <th scope="col" style="width: 40%">
                                    <i class="fas fa-book me-1"></i>
                                    Nom de la Matière
                                </th>
                                <th scope="col" class="text-center" style="width: 20%">
                                    <i class="fas fa-weight me-1"></i>
                                    Coefficient
                                </th>
                                <th scope="col" class="text-center" style="width: 35%">
                                    <i class="fas fa-cogs me-1"></i>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matieres as $index => $matiere)
                                <tr class="align-middle">
                                    <td class="text-center fw-bold text-muted">
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-book text-white"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $matiere->nomM }}
                                                </div>
                                                <small class="text-muted">
                                                    ID: {{ $matiere->id }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $coeff = $matiere->coefficient;
                                            $badgeClass = '';
                                            if ($coeff >= 4) $badgeClass = 'bg-danger';
                                            elseif ($coeff >= 3) $badgeClass = 'bg-warning';
                                            elseif ($coeff >= 2) $badgeClass = 'bg-info';
                                            else $badgeClass = 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }} fs-6 px-3 py-2">
                                            {{ $matiere->coefficient }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.matieres.show', $matiere) }}" 
                                               class="btn btn-info btn-sm"
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                                <span class="d-none d-md-inline ms-1">Détails</span>
                                            </a>
                                            <a href="{{ route('admin.matieres.edit', $matiere) }}" 
                                               class="btn btn-warning btn-sm"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                                <span class="d-none d-md-inline ms-1">Modifier</span>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $matiere->id }}, '{{ $matiere->nomM }}')"
                                                    title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                                <span class="d-none d-md-inline ms-1">Supprimer</span>
                                            </button>
                                        </div>
                                        
                                        <!-- Formulaire de suppression caché -->
                                        <form id="delete-form-{{ $matiere->id }}" 
                                              action="{{ route('admin.matieres.destroy', $matiere) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistiques rapides -->
    @if($matieres->isNotEmpty())
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <div class="text-primary mb-2">
                            <i class="fas fa-calculator fa-2x"></i>
                        </div>
                        <h5 class="card-title">Coefficient Moyen</h5>
                        <h3 class="text-primary">{{ number_format($matieres->avg('coefficient'), 1) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <div class="text-success mb-2">
                            <i class="fas fa-arrow-up fa-2x"></i>
                        </div>
                        <h5 class="card-title">Coefficient Max</h5>
                        <h3 class="text-success">{{ $matieres->max('coefficient') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <div class="text-info mb-2">
                            <i class="fas fa-arrow-down fa-2x"></i>
                        </div>
                        <h5 class="card-title">Coefficient Min</h5>
                        <h3 class="text-info">{{ $matieres->min('coefficient') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la matière <strong id="matiere-name"></strong> ?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-warning me-2"></i>
                    Cette action est irréversible et supprimera toutes les notes associées à cette matière.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Annuler
                </button>
                <button type="button" class="btn btn-danger" id="confirm-delete">
                    <i class="fas fa-trash me-1"></i>
                    Supprimer
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.avatar-sm {
    width: 40px;
    height: 40px;
}

.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.1);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn {
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e3e6f0;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.input-group-text {
    border-radius: 10px 0 0 10px;
    border: 2px solid #e3e6f0;
    border-right: none;
}

.alert {
    border-radius: 10px;
    border: none;
}

.badge {
    border-radius: 8px;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.modal-content {
    border-radius: 15px;
    border: none;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 15px;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column !important;
        gap: 15px;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when typing in search field
    const searchInput = document.getElementById('search');
    const searchForm = searchInput.closest('form');
    const sortSelect = document.getElementById('sort_by');
    let timeoutId;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
            searchForm.submit();
        }, 500); // Attendre 500ms après la dernière frappe
    });

    // Auto-submit form when changing sort
    sortSelect.addEventListener('change', function() {
        searchForm.submit();
    });
});

// Fonction de confirmation de suppression
function confirmDelete(id, name) {
    document.getElementById('matiere-name').textContent = name;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
    
    document.getElementById('confirm-delete').onclick = function() {
        document.getElementById('delete-form-' + id).submit();
    };
}

// Animation au chargement
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection