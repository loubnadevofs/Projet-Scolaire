@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-3">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fas fa-chalkboard-teacher text-primary me-2"></i>
                Liste des Formateurs
            </h1>
            <p class="text-muted mb-0">Gérez vos formateurs et enseignants</p>
        </div>
        <a href="{{ route('admin.enseignants.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i>Ajouter un Formateur
        </a>
    </div>

    <!-- Search and Filter Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0" 
                               id="searchInput" 
                               placeholder="Rechercher par nom, prénom ou email...">
                    </div>
                </div>
                <div class="col-md-6 text-end mt-2 mt-md-0">
                    <span class="text-muted">
                        <span id="resultCount">{{ count($enseignants) }}</span> formateur(s) trouvé(s)
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-primary text-white border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-users me-2"></i>
                        Liste des Formateurs
                    </h6>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if(count($enseignants) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="formateurTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-bold text-uppercase text-xs text-muted ps-4">
                                    <i class="fas fa-user me-2"></i>Nom
                                </th>
                                <th class="border-0 fw-bold text-uppercase text-xs text-muted">
                                    <i class="fas fa-id-badge me-2"></i>Prénom
                                </th>
                                <th class="border-0 fw-bold text-uppercase text-xs text-muted">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </th>
                                <th class="border-0 fw-bold text-uppercase text-xs text-muted text-center">
                                    <i class="fas fa-cogs me-2"></i>Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enseignants as $enseignant)
                                <tr class="formateur-row">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-3">
                                                {{ strtoupper(substr($enseignant->nom, 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold formateur-nom">{{ $enseignant->nom }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="formateur-prenom">{{ $enseignant->prenom }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-muted formateur-email">
                                            <i class="fas fa-envelope me-1"></i>
                                            {{ $enseignant->email }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.enseignants.show', $enseignant->idEnsei) }}" 
                                               class="btn btn-outline-info btn-sm" 
                                               data-bs-toggle="tooltip" 
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.enseignants.edit', $enseignant->idEnsei) }}" 
                                               class="btn btn-outline-warning btn-sm"
                                               data-bs-toggle="tooltip" 
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger btn-sm"
                                                    data-bs-toggle="tooltip" 
                                                    title="Supprimer"
                                                    onclick="confirmDelete('{{ route('admin.enseignants.destroy', $enseignant->idEnsei) }}', '{{ $enseignant->nom }} {{ $enseignant->prenom }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-muted mb-2">Aucun formateur trouvé</h5>
                    <p class="text-muted mb-3">Commencez par ajouter votre premier formateur</p>
                    <a href="{{ route('admin.enseignants.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter un Formateur
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- No Results Message (Hidden by default) -->
    <div class="card shadow-sm border-0 mt-4" id="noResultsCard" style="display: none;">
        <div class="card-body text-center py-5">
            <div class="mb-3">
                <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
            </div>
            <h5 class="text-muted mb-2">Aucun résultat trouvé</h5>
            <p class="text-muted">Essayez de modifier vos critères de recherche</p>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Êtes-vous sûr de vouloir supprimer le formateur <strong id="formateurName"></strong> ?</p>
                <p class="text-muted mt-2 mb-0">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn-group .btn {
    margin: 0 1px;
}

.card {
    border-radius: 0.75rem;
}

.input-group .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.text-xs {
    font-size: 0.75rem;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.table th {
    font-weight: 600;
    letter-spacing: 0.5px;
}

.btn-outline-info:hover,
.btn-outline-warning:hover,
.btn-outline-danger:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('formateurTable');
    const resultCount = document.getElementById('resultCount');
    const noResultsCard = document.getElementById('noResultsCard');
    const rows = document.querySelectorAll('.formateur-row');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;

        rows.forEach(function(row) {
            const nom = row.querySelector('.formateur-nom').textContent.toLowerCase();
            const prenom = row.querySelector('.formateur-prenom').textContent.toLowerCase();
            const email = row.querySelector('.formateur-email').textContent.toLowerCase();

            const matches = nom.includes(searchTerm) || 
                          prenom.includes(searchTerm) || 
                          email.includes(searchTerm);

            if (matches) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update result count
        resultCount.textContent = visibleCount;

        // Show/hide no results message
        if (visibleCount === 0 && searchTerm !== '') {
            table.style.display = 'none';
            noResultsCard.style.display = 'block';
        } else {
            table.style.display = '';
            noResultsCard.style.display = 'none';
        }
    });
});

// Delete confirmation function
function confirmDelete(url, formateurName) {
    document.getElementById('formateurName').textContent = formateurName;
    document.getElementById('deleteForm').action = url;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endsection