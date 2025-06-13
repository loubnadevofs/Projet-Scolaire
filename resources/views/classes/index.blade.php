@extends('layouts.admin')

@section('title', 'Liste des Classes')

@section('content')
<div class="container-fluid">
    <!-- En-tête avec titre et bouton d'ajout -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-school text-primary me-2"></i>
                        Gestion des Classes
                    </h1>
                    <p class="text-muted mb-0">Gérez et organisez vos classes scolaires</p>
                </div>
                <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="fas fa-plus me-2"></i>
                    Nouvelle Classe
                </a>
            </div>
        </div>
    </div>

    <!-- Carte principale -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="fas fa-list me-2 text-primary"></i>
                        Liste des Classes
                    </h5>
                </div>
                <div class="col-md-4">
                    <!-- Champ de recherche -->
                    <div class="input-group">
                        <input type="text" 
                               id="searchInput" 
                               class="form-control form-control-sm" 
                               placeholder="Rechercher par nom ou niveau..."
                               style="border-radius: 20px 0 0 20px;">
                        <div class="input-group-append">
                            <span class="input-group-text bg-primary text-white" style="border-radius: 0 20px 20px 0;">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Statistiques rapides -->
            <div class="row text-center py-3 bg-light">
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-graduation-cap text-success fa-2x me-3"></i>
                        <div>
                            <h4 class="mb-0 text-success">{{ $classes->count() }}</h4>
                            <small class="text-muted">Total Classes</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-layer-group text-warning fa-2x me-3"></i>
                        <div>
                            <h4 class="mb-0 text-warning">{{ $classes->unique('niveau')->count() }}</h4>
                            <small class="text-muted">Niveaux</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des classes -->
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="classesTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="border-0 py-3">
                                <i class="fas fa-hashtag me-2"></i>ID
                            </th>
                            <th class="border-0 py-3">
                                <i class="fas fa-tag me-2"></i>Nom de la Classe
                            </th>
                            <th class="border-0 py-3">
                                <i class="fas fa-layer-group me-2"></i>Niveau
                            </th>
                            <th class="border-0 py-3 text-center">
                                <i class="fas fa-cogs me-2"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $classe)
                            <tr class="classe-row">
                                <td class="py-3">
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                        {{ $classe->idClasse }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-school text-white"></i>
                                        </div>
                                        <div>
                                            <strong class="text-dark classe-nom">{{ $classe->nom }}</strong>
                                            <br>
                                            <small class="text-muted">Classe {{ $classe->nom }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge 
                                        @switch($classe->niveau)
                                            @case('Primaire') bg-success @break
                                            @case('Collège') bg-info @break
                                            @case('Lycée') bg-warning @break
                                            @default bg-secondary
                                        @endswitch
                                        px-3 py-2 classe-niveau">
                                        {{ $classe->niveau }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.classes.show', $classe->idClasse) }}" 
                                           class="btn btn-outline-info btn-sm" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.classes.edit', $classe->idClasse) }}" 
                                           class="btn btn-outline-warning btn-sm" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.classes.destroy', $classe->idClasse) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer la classe {{ $classe->nom }} ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noResultsRow">
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-search fa-3x mb-3"></i>
                                        <h5>Aucune classe trouvée</h5>
                                        <p>Commencez par ajouter votre première classe</p>
                                        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Ajouter une classe
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pied de carte avec pagination si nécessaire -->
        @if(method_exists($classes, 'links'))
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Affichage de {{ $classes->count() }} classe(s)
                    </small>
                    {{ $classes->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Script pour la recherche -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableRows = document.querySelectorAll('.classe-row');
    const noResultsRow = document.getElementById('noResultsRow');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleRowsCount = 0;

        tableRows.forEach(function(row) {
            const nom = row.querySelector('.classe-nom').textContent.toLowerCase();
            const niveau = row.querySelector('.classe-niveau').textContent.toLowerCase();
            
            if (nom.includes(searchTerm) || niveau.includes(searchTerm)) {
                row.style.display = '';
                visibleRowsCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Afficher/masquer le message "Aucun résultat"
        if (visibleRowsCount === 0 && searchTerm !== '') {
            if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }
            // Créer un message de recherche vide si nécessaire
            showNoSearchResults();
        } else {
            hideNoSearchResults();
            if (noResultsRow && tableRows.length === 0) {
                noResultsRow.style.display = '';
            }
        }
    });

    function showNoSearchResults() {
        const existingMsg = document.getElementById('noSearchResults');
        if (!existingMsg) {
            const tbody = document.querySelector('#classesTable tbody');
            const noSearchRow = document.createElement('tr');
            noSearchRow.id = 'noSearchResults';
            noSearchRow.innerHTML = `
                <td colspan="4" class="text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-search-minus fa-3x mb-3"></i>
                        <h5>Aucun résultat trouvé</h5>
                        <p>Aucune classe ne correspond à votre recherche</p>
                    </div>
                </td>
            `;
            tbody.appendChild(noSearchRow);
        }
    }

    function hideNoSearchResults() {
        const existingMsg = document.getElementById('noSearchResults');
        if (existingMsg) {
            existingMsg.remove();
        }
    }
});
</script>

<style>
/* Styles personnalisés */
.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: 2px solid #e3e6f0;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn-group .btn {
    margin: 0 2px;
}

.badge {
    font-size: 0.85em;
    font-weight: 500;
}

.input-group-text {
    border: 1px solid #d1d3e2;
}

.form-control:focus {
    border-color: #5a5c69;
    box-shadow: 0 0 0 0.2rem rgba(90, 92, 105, 0.25);
}

.btn-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #224abe, #1e3a8a);
    transform: translateY(-1px);
}

.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin: 1px 0;
        border-radius: 4px !important;
    }
}
</style>
@endsection