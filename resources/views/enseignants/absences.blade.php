@extends('layouts.enseignant')

@section('title', 'Suivi des Absences')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Suivi des Absences</h3>
                    <!-- Move Add button to header for better visibility -->
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAbsenceModal">
                        <i class="fas fa-plus"></i> Ajouter Absence
                    </button>
                </div>
                
                <div class="card-body">
                    <!-- Messages de succès/erreur -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Formulaire de filtrage -->
                    <form method="GET" action="{{ route('enseignant.absences') }}" class="mb-4" id="filterForm">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="classe_id" class="form-label">Filtrer par classe</label>
                                <select name="classe_id" id="classe_id" class="form-select" onchange="loadMatieres()">
                                    <option value="">-- Toutes les classes --</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->idClasse }}" 
                                                data-niveau="{{ $classe->niveau }}"
                                                {{ $classe_id == $classe->idClasse ? 'selected' : '' }}>
                                            {{ $classe->nom_classe }} - {{ $classe->niveau }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-4" id="matiere-container" style="{{ $classe_id ? '' : 'display:none;' }}">
                                <label for="matiere_id" class="form-label">Filtrer par matière</label>
                                <select name="matiere_id" id="matiere_id" class="form-select">
                                    <option value="">-- Toutes les matières --</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-filter"></i> Filtrer
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="resetFilter()">
                                    <i class="fas fa-refresh"></i> Réinitialiser
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Show statistics and table always, but modify content based on filters -->
                    @if($absences && $absences->count() > 0)
                        <!-- Statistiques rapides -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $absences->count() }}</h4>
                                                <p class="mb-0">Total Absences</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-user-times fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $absences->sum('nbrHeuAbsence') }}</h4>
                                                <p class="mb-0">Heures Perdues</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ $absences->unique('idEtu')->count() }}</h4>
                                                <p class="mb-0">Étudiants Concernés</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-users fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-secondary text-white">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4>{{ number_format($absences->avg('nbrHeuAbsence'), 1) }}</h4>
                                                <p class="mb-0">Moyenne H/Absence</p>
                                            </div>
                                            <div class="align-self-center">
                                                <i class="fas fa-chart-line fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tableau des absences -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nom Complet</th>
                                        <th>Classe</th>
                                        <th>Date d'Absence</th>
                                        <th>Nombre d'Heures</th>
                                        <th>Type</th>
                                        <th>Justifiée</th>
                                        <th>Jour de la Semaine</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absences as $index => $absence)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        {{ strtoupper(substr($absence->etudiant->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($absence->etudiant->nom ?? '', 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <strong>{{ $absence->etudiant->nom ?? 'N/A' }} {{ $absence->etudiant->prenom ?? '' }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ $absence->classe->nom ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ \Carbon\Carbon::parse($absence->dateAbsen)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($absence->nbrHeuAbsence >= 4)
                                                    <span class="badge bg-danger">{{ $absence->nbrHeuAbsence }}h</span>
                                                @elseif($absence->nbrHeuAbsence >= 2)
                                                    <span class="badge bg-warning">{{ $absence->nbrHeuAbsence }}h</span>
                                                @else
                                                    <span class="badge bg-success">{{ $absence->nbrHeuAbsence }}h</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($absence->type_absence))
                                                    @if($absence->type_absence == 'absence')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-user-times"></i> Absence
                                                        </span>
                                                    @elseif($absence->type_absence == 'retard')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock"></i> Retard
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="fas fa-question"></i> Non définie
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-question"></i> Non définie
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($absence->justifiee))
                                                    @if($absence->justifiee == 1)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i> Justifiée
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times"></i> Non justifiée
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-question"></i> Non définie
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($absence->dateAbsen)->locale('fr')->dayName }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editModal{{ $absence->idA }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                   <button type="button" class="btn btn-sm btn-outline-danger"
                    onclick="confirmDeleteWithFetch({{ $absence->idA }})">
                <i class="fas fa-trash"></i>
            </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal d'édition -->
                                        <div class="modal fade" id="editModal{{ $absence->idA }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Modifier l'Absence</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST" action="{{ route('enseignant.update-absence', $absence->idA) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Étudiant</label>
                                                                <input type="text" class="form-control" 
                                                                       value="{{ $absence->etudiant->nom ?? 'N/A' }} {{ $absence->etudiant->prenom ?? '' }}" 
                                                                       readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="date_absence_{{ $absence->idA }}" class="form-label">Date d'Absence</label>
                                                                <input type="date" 
                                                                       class="form-control" 
                                                                       id="date_absence_{{ $absence->idA }}"
                                                                       name="date_absence" 
                                                                       value="{{ $absence->dateAbsen }}" 
                                                                       required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nbr_heures_{{ $absence->idA }}" class="form-label">Nombre d'Heures</label>
                                                                <input type="number" 
                                                                       class="form-control" 
                                                                       id="nbr_heures_{{ $absence->idA }}"
                                                                       name="nbr_heures" 
                                                                       value="{{ $absence->nbrHeuAbsence }}" 
                                                                       min="1" 
                                                                       max="8" 
                                                                       required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="type_absence_{{ $absence->idA }}" class="form-label">Type</label>
                                                                        <select class="form-select" 
                                                                                id="type_absence_{{ $absence->idA }}" 
                                                                                name="type_absence">
                                                                            <option value="absence" {{ (isset($absence->type_absence) && $absence->type_absence == 'absence') ? 'selected' : '' }}>Absence</option>
                                                                            <option value="retard" {{ (isset($absence->type_absence) && $absence->type_absence == 'retard') ? 'selected' : '' }}>Retard</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <div class="form-check mt-4">
                                                                            <input class="form-check-input" 
                                                                                   type="checkbox" 
                                                                                   id="justifiee_edit_{{ $absence->idA }}" 
                                                                                   name="justifiee"
                                                                                   value="1"
                                                                                   {{ (isset($absence->justifiee) && $absence->justifiee == 1) ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="justifiee_edit_{{ $absence->idA }}">
                                                                                Absence justifiée
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="motif_{{ $absence->idA }}" class="form-label">Motif (optionnel)</label>
                                                                <textarea class="form-control" 
                                                                          id="motif_{{ $absence->idA }}" 
                                                                          name="motif" 
                                                                          rows="3">{{ $absence->motif ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Résumé par étudiant -->
                        <div class="mt-4">
                            <h5>Résumé par Étudiant</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Étudiant</th>
                                            <th>Classe</th>
                                            <th>Nombre d'Absences</th>
                                            <th>Total Heures</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $groupedAbsences = $absences->groupBy('idEtu');
                                        @endphp
                                        @foreach($groupedAbsences as $etudiantId => $etudiantAbsences)
                                            @php
                                                $totalHeures = $etudiantAbsences->sum('nbrHeuAbsence');
                                                $nombreAbsences = $etudiantAbsences->count();
                                                $firstAbsence = $etudiantAbsences->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $firstAbsence->etudiant->nom ?? 'N/A' }} {{ $firstAbsence->etudiant->prenom ?? '' }}</td>
                                                <td>{{ $firstAbsence->classe->nom }}</td>
                                                <td>{{ $nombreAbsences }}</td>
                                                <td>{{ $totalHeures }}h</td>
                                                <td>
                                                    @if($totalHeures >= 20)
                                                        <span class="badge bg-danger">Critique</span>
                                                    @elseif($totalHeures >= 10)
                                                        <span class="badge bg-warning">Attention</span>
                                                    @else
                                                        <span class="badge bg-success">Normal</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>Aucune absence enregistrée</h5>
                            <p>
                                @if($classe_id)
                                    Il n'y a aucune absence enregistrée pour cette classe.
                                @else
                                    Il n'y a aucune absence enregistrée dans le système.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout d'absence -->
<div class="modal fade" id="addAbsenceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter une Absence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('enseignant.store-absence') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_classe_select" class="form-label">Sélectionner une classe</label>
                                <select class="form-select" id="add_classe_select" name="classe_id" required onchange="loadEtudiantsForClass()">
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->idClasse }}">{{ $classe->nom_classe }} - {{ $classe->niveau }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_etudiant_id" class="form-label">Sélectionner les étudiants</label>
                                <select class="form-select" id="add_etudiant_id" name="etudiants[]" multiple required>
                                    <option value="">-- Choisir d'abord une classe --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_date_absence" class="form-label">Date d'Absence</label>
                                <input type="date" class="form-control" id="add_date_absence" name="dateAbsen" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_nbr_heures" class="form-label">Nombre d'Heures</label>
                                <input type="number" class="form-control" id="add_nbr_heures" name="nbrHeuAbsence" min="1" max="8" value="1" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="add_type_absence" class="form-label">Type</label>
                                <select class="form-select" id="add_type_absence" name="type_absence">
                                    <option value="absence">Absence</option>
                                    <option value="retard">Retard</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="add_justifiee" 
                                           name="justifiee"
                                           value="1">
                                    <label class="form-check-label" for="add_justifiee">
                                        Absence justifiée
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_motif" class="form-label">Motif (optionnel)</label>
                        <textarea class="form-control" id="add_motif" name="motif" rows="3" placeholder="Raison de l'absence..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer l'Absence</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
// Variables globales
let classesData = @json($classes);
let currentClasseId = {{ $classe_id ?: 'null' }};
let currentMatiereId = {{ $matiere_id ?: 'null' }};

// Fonction pour charger les matières d'une classe
function loadMatieres() {
    const classeSelect = document.getElementById('classe_id');
    const matiereSelect = document.getElementById('matiere_id');
    const matiereContainer = document.getElementById('matiere-container');
    
    const classeId = classeSelect.value;
    
    if (classeId) {
        // Afficher le conteneur
        matiereContainer.style.display = 'block';
        
        // Vider le select des matières
        matiereSelect.innerHTML = '<option value="">-- Toutes les matières --</option>';
        
        // Filtrer les matières pour cette classe
        const matieres = classesData.filter(item => item.idClasse == classeId);
        
        matieres.forEach(function(matiere) {
            const option = document.createElement('option');
            option.value = matiere.idMatiere;
            option.textContent = matiere.nom_matiere;
            matiereSelect.appendChild(option);
        });
        
        // Sélectionner la matière si elle est déjà choisie
        if (currentMatiereId) {
            matiereSelect.value = currentMatiereId;
        }
    } else {
        matiereContainer.style.display = 'none';
    }
}

// Fonction pour charger les étudiants d'une classe pour le modal d'ajout
function loadEtudiantsForClass() {
    const classeId = document.getElementById('add_classe_select').value;
    const etudiantSelect = document.getElementById('add_etudiant_id');
    
    if (!classeId) {
        etudiantSelect.innerHTML = '<option value="">-- Choisir d\'abord une classe --</option>';
        return;
    }
    
    // Afficher le chargement
    etudiantSelect.innerHTML = '<option value="">Chargement...</option>';
    
    fetch(`/enseignant/get-etudiants/${classeId}`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.length === 0) {
            etudiantSelect.innerHTML = '<option value="">Aucun étudiant trouvé</option>';
            return;
        }
        
        let html = '<option value="">-- Choisir un ou plusieurs étudiants --</option>';
        data.forEach(etudiant => {
            html += `<option value="${etudiant.idEtu}">${etudiant.nom} ${etudiant.prenom}</option>`;
        });
        etudiantSelect.innerHTML = html;
    })
    .catch(error => {
        console.error('Error:', error);
        etudiantSelect.innerHTML = '<option value="">Erreur de chargement</option>';
    });
}

// Fonction pour réinitialiser les filtres
function resetFilter() {
    document.getElementById('classe_id').value = '';
    document.getElementById('matiere_id').value = '';
    document.getElementById('matiere-container').style.display = 'none';
    document.getElementById('filterForm').submit();
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Charger les matières si une classe est déjà sélectionnée
    if (currentClasseId) {
        loadMatieres();
    }
});

/// Fonction pour confirmer la suppression - CORRIGÉE
function confirmDelete(absenceId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')) {
        const form = document.getElementById('deleteForm');
        // Correction de l'URL - utilisez la route correcte
        form.action = `/enseignant/absences/${absenceId}`;  // Enlevé le 's' de 'enseignants'
        form.submit();
    }
}

// OU si votre route utilise un nom différent, utilisez helper route() de Laravel :
function confirmDeleteWithRoute(absenceId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')) {
        const form = document.getElementById('deleteForm');
        // Utilisez la route nommée Laravel
        form.action = '{{ route("enseignant.delete-absence", "") }}/' + absenceId;
        form.submit();
    }
}

// Alternative avec fetch API pour une meilleure gestion d'erreurs
function confirmDeleteWithFetch(absenceId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        fetch(`/enseignant/absences/${absenceId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Erreur lors de la suppression');
        })
        .then(data => {
            if (data.success) {
                // Recharger la page ou supprimer la ligne du tableau
                location.reload();
                // OU supprimer la ligne sans recharger :
                // document.querySelector(`tr[data-absence-id="${absenceId}"]`).remove();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la suppression de l\'absence');
        });
    }
}

function resetAddModal() {
    document.getElementById('add_classe_select').value = '';
    document.getElementById('add_etudiant_id').innerHTML = '<option value="">-- Choisir d\'abord une classe --</option>';
    document.getElementById('add_date_absence').value = '{{ date("Y-m-d") }}';
    document.getElementById('add_nbr_heures').value = '1';
    document.getElementById('add_type_absence').value = 'absence';
    document.getElementById('add_justifiee').checked = false;
    document.getElementById('add_motif').value = '';
}

// Événement pour réinitialiser le modal quand il se ferme
document.getElementById('addAbsenceModal').addEventListener('hidden.bs.modal', function () {
    resetAddModal();
});
function loadEditModal(absenceId, typeAbsence, justifiee) {
    const typeSelect = document.getElementById('type_absence_' + absenceId);
    const justifieeCheckbox = document.getElementById('justifiee_edit_' + absenceId);
    
    if (typeSelect) {
        typeSelect.value = typeAbsence || 'absence';
    }
    
    if (justifieeCheckbox) {
        justifieeCheckbox.checked = justifiee == 1;
    }
}
</script>
@endpush

@push('styles')
<style>
.avatar {
    font-size: 12px;
    font-weight: bold;
}

.table th {
    border-top: none;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.badge {
    font-size: 0.75em;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

.alert i {
    color: inherit;
}

.table-responsive {
    border-radius: 0.375rem;
}

#matiere-container {
    transition: all 0.3s ease;
}

.custom-table th, .custom-table td {
    vertical-align: middle;
    text-align: center;
}

.custom-table tbody tr:hover {
    background-color: #f1f1f1;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.action-btn {
    transition: all 0.3s ease;
}

.action-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.action-btn.btn-info:hover {
    background-color: #17a2b8;
    border-color: #17a2b8;
}

.action-btn.btn-warning:hover {
    background-color: #ffc107;
    border-color: #ffc107;
}
.form-check {
    padding-left: 1.5em;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.badge i {
    font-size: 0.8em;
    margin-right: 2px;
}

.table td {
    vertical-align: middle;
}

/* Style pour les badges de justification */
.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
}

.badge.bg-secondary {
    background-color: #6c757d !important;
}

.action-btn.btn-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
}

.text-warning {
    font-weight: bold;
    color: #f39c12;
}
</style>
@endpush