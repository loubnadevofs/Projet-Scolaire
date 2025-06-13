@extends('layouts.enseignant')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Gestion des Résultats</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Barre de recherche avancée -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-search"></i> Rechercher les résultats
                                <button class="btn btn-sm btn-outline-secondary float-end" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </h5>
                        </div>
                        <div class="collapse show" id="searchCollapse">
                            <div class="card-body">
                                <form method="GET" id="searchForm">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Classe:</label>
                                            <select name="classe_id" class="form-control" id="search_classe">
                                                <option value="">Toutes les classes</option>
                                                @foreach($classes as $classe)
                                                    <option value="{{ $classe->idClasse }}" 
                                                        {{ request('classe_id') == $classe->idClasse ? 'selected' : '' }}>
                                                        {{ $classe->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Matière:</label>
                                            <select name="matiere_id" class="form-control" id="search_matiere">
                                                <option value="">Toutes les matières</option>
                                                @foreach($matieres as $matiere)
                                                    <option value="{{ $matiere->idMatiere }}" 
                                                        {{ request('matiere_id') == $matiere->idMatiere ? 'selected' : '' }}>
                                                        {{ $matiere->nomM }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                      
                                        
                                    </div>
                                    <div class="row mt-3">
                                        
                                       
                                       
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="fas fa-search"></i> Rechercher
                                            </button>
                                            <button type="button" class="btn btn-secondary me-2" onclick="clearSearch()">
                                                <i class="fas fa-times"></i> Effacer
                                            </button>
                                            <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#quickNoteModal">
                                                <i class="fas fa-plus"></i> Ajouter une note
                                            </button>
                                           
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    @if(count($resultats) > 0)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ count($resultats) }}</h4>
                                        <small>Total résultats</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $resultats->where('note', '>=', 10)->count() }}</h4>
                                        <small>Réussites (≥10)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ $resultats->where('note', '<', 10)->count() }}</h4>
                                        <small>Échecs (<10)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h4>{{ number_format($resultats->avg('note'), 2) }}</h4>
                                        <small>Moyenne générale</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tableau des résultats -->
                    @if(count($resultats) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="selectAll"> 
                                            <span class="ms-1">Étudiant</span>
                                        </th>
                                        <th>Classe</th>
                                        <th>Matière</th>
                                        <th>Note</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="resultatsTable">
                                    @foreach($resultats as $resultat)
                                        <tr id="row-{{ $resultat->id }}">
                                            <td>
                                                <input type="checkbox" class="row-checkbox" value="{{ $resultat->id }}">
                                                <span class="ms-2">{{ $resultat->etudiant->nom }} {{ $resultat->etudiant->prenom }}</span>
                                            </td>
                                            <td>{{ $resultat->classe->nom }}</td>
                                            <td>{{ $resultat->matiere->nomM }}</td>
                                            <td class="{{ $resultat->note < 10 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                                {{ number_format($resultat->note, 2) }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($resultat->dateEv)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $resultat->type_evaluation == 'Examen' ? 'danger' : ($resultat->type_evaluation == 'Contrôle' ? 'warning' : 'info') }}">
                                                    {{ $resultat->type_evaluation }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-primary edit-note" 
                                                       data-id="{{ $resultat->id }}" 
                                                       data-etudiant="{{ $resultat->etudiant->nom }} {{ $resultat->etudiant->prenom }}"
                                                       data-classe="{{ $resultat->classe->nom }}"
                                                       data-matiere="{{ $resultat->matiere->nomM }}"
                                                       data-note="{{ $resultat->note }}"
                                                       data-type="{{ $resultat->type_evaluation }}"
                                                       data-date="{{ $resultat->dateEv }}"
                                                       title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-note" 
                                                            data-id="{{ $resultat->id }}"
                                                            data-etudiant="{{ $resultat->etudiant->nom }} {{ $resultat->etudiant->prenom }}"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Actions en lot -->
                        <div class="mt-3" id="bulkActions" style="display: none;">
                            <div class="alert alert-warning">
                                <strong>Actions sélectionnées:</strong>
                                <button class="btn btn-sm btn-danger ms-2" onclick="deleteSelected()">
                                    <i class="fas fa-trash"></i> Supprimer sélectionnées
                                </button>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        @if(method_exists($resultats, 'links'))
                            <div class="d-flex justify-content-center">
                                {{ $resultats->links() }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-3"></i>
                            <h5>Aucun résultat trouvé</h5>
                            <p>Aucun résultat ne correspond aux critères de recherche sélectionnés.</p>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#quickNoteModal">
                                <i class="fas fa-plus"></i> Ajouter la première note
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout de note rapide -->
<div class="modal fade" id="quickNoteModal" tabindex="-1" aria-labelledby="quickNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="quickNoteModalLabel">
                    <i class="fas fa-plus-circle"></i> Ajouter une note rapide
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form id="quickNoteForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quick_classe_id" class="form-label">
                                    <i class="fas fa-school"></i> Classe *
                                </label>
                                <select id="quick_classe_id" name="classe_id" class="form-control" required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->idClasse }}">{{ $classe->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quick_matiere_id" class="form-label">
                                    <i class="fas fa-book"></i> Matière *
                                </label>
                                <select id="quick_matiere_id" name="matiere_id" class="form-control" required>
                                    <option value="">-- Choisir une matière --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quick_etudiant_id" class="form-label">
                                    <i class="fas fa-user-graduate"></i> Étudiant *
                                </label>
                                <select id="quick_etudiant_id" name="etudiant_id" class="form-control" required>
                                    <option value="">-- Choisir un étudiant --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quick_note" class="form-label">
                                    <i class="fas fa-star"></i> Note (0-20) *
                                </label>
                                <input type="number" id="quick_note" name="note" class="form-control" 
                                       min="0" max="20" step="0.25" required 
                                       placeholder="Entrer la note">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quick_type_evaluation" class="form-label">
                                    <i class="fas fa-clipboard-check"></i> Type d'évaluation *
                                </label>
                                <select id="quick_type_evaluation" name="type_evaluation" class="form-control" required>
                                    <option value="">-- Choisir le type --</option>
                                    <option value="Contrôle">Contrôle</option>
                                    <option value="Devoir">Devoir</option>
                                    <option value="Examen">Examen</option>
                                    <option value="Participation">Participation</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quick_date_evaluation" class="form-label">
                                    <i class="fas fa-calendar"></i> Date d'évaluation *
                                </label>
                                <input type="date" id="quick_date_evaluation" name="date_evaluation" 
                                       class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div id="loading" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="mt-2">Chargement en cours...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer la note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de modification -->
<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editNoteModalLabel">
                    <i class="fas fa-edit"></i> Modifier la note
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editNoteForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_note_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Étudiant:</strong></label>
                        <p id="edit_etudiant_info" class="text-muted"></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_note" class="form-label">
                            <i class="fas fa-star"></i> Note (0-20) *
                        </label>
                        <input type="number" id="edit_note" name="note" class="form-control" 
                               min="0" max="20" step="0.25" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_type_evaluation" class="form-label">
                            <i class="fas fa-clipboard-check"></i> Type d'évaluation *
                        </label>
                        <select id="edit_type_evaluation" name="type_evaluation" class="form-control" required>
                            <option value="Contrôle">Contrôle</option>
                            <option value="Devoir">Devoir</option>
                            <option value="Examen">Examen</option>
                            <option value="Participation">Participation</option>
                        </select>
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function() {
    // Configuration AJAX globale
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Gestion des cases à cocher
    $('#selectAll').change(function() {
        $('.row-checkbox').prop('checked', this.checked);
        toggleBulkActions();
    });
    
    $(document).on('change', '.row-checkbox', function() {
        toggleBulkActions();
        
        const total = $('.row-checkbox').length;
        const checked = $('.row-checkbox:checked').length;
        $('#selectAll').prop('indeterminate', checked > 0 && checked < total);
        $('#selectAll').prop('checked', checked === total);
    });
    
    function toggleBulkActions() {
        const checked = $('.row-checkbox:checked').length;
        $('#bulkActions').toggle(checked > 0);
    }
    
    // Auto-submit sur changement de classe/matière
    $('#search_classe, #search_matiere').change(function() {
        $('#searchForm').submit();
    });
    
    // Gestion du modal d'ajout rapide
    $('#quick_classe_id').change(function() {
        const classeId = $(this).val();
        const matiereSelect = $('#quick_matiere_id');
        const etudiantSelect = $('#quick_etudiant_id');
        
        matiereSelect.html('<option value="">-- Choisir une matière --</option>');
        etudiantSelect.html('<option value="">-- Choisir un étudiant --</option>');
        
        if (classeId) {
            const matieres = @json($matieres);
            matieres.forEach(function(matiere) {
                matiereSelect.append(`<option value="${matiere.idMatiere}">${matiere.nomM}</option>`);
            });
        }
    });
    
    $('#quick_matiere_id').change(function() {
        const classeId = $('#quick_classe_id').val();
        const matiereId = $(this).val();
        const etudiantSelect = $('#quick_etudiant_id');
        
        etudiantSelect.html('<option value="">-- Choisir un étudiant --</option>');
        
        if (classeId && matiereId) {
            $('#loading').show();
            
            $.ajax({
                url: '{{ route("enseignant.get-students-by-class-matiere") }}',
                method: 'GET',
                data: { 
                    classe_id: classeId, 
                    matiere_id: matiereId 
                },
                success: function(response) {
                    $('#loading').hide();
                    response.forEach(function(etudiant) {
                        etudiantSelect.append(`<option value="${etudiant.idEtu}">${etudiant.nom} ${etudiant.prenom}</option>`);
                    });
                },
                error: function(xhr) {
                    $('#loading').hide();
                    let errorMsg = 'Erreur lors du chargement des étudiants';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    showAlert('danger', errorMsg);
                    console.error(xhr.responseText); // Log full error to console
                }
            });
        }
    });
    
    // Envoi du formulaire d'ajout
    $('#quickNoteForm').submit(function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        
        // DEBUG: Afficher les données envoyées
        console.log('Données du formulaire:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Enregistrement...');
        
        $.ajax({
            url: '{{ route("enseignant.store-quick-note") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Réponse du serveur:', response);
                if (response.success) {
                    $('#quickNoteModal').modal('hide');
                    showAlert('success', response.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert('danger', response.message || 'Erreur inconnue');
                }
            },
            error: function(xhr) {
                console.error('Erreur AJAX:', xhr);
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseText);
                
                if (xhr.status === 422) { // Validation error
                    const errors = xhr.responseJSON.errors;
                    let errorMessages = [];
                    for (let field in errors) {
                        errorMessages.push(`${field}: ${errors[field].join(', ')}`);
                    }
                    showAlert('danger', errorMessages.join('<br>'));
                } else {
                    let errorMsg = 'Erreur lors de l\'enregistrement';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        errorMsg += ': ' + xhr.responseText;
                    }
                    showAlert('danger', errorMsg);
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Enregistrer la note');
            }
        });
    }); // Cette accolade ferme le handler submit qui était manquante
    
    // Modification d'une note
    $(document).on('click', '.edit-note', function() {
        const noteId = $(this).data('id');
        const currentData = $(this).data();
        
        $('#edit_note_id').val(noteId);
        $('#edit_etudiant_info').text(`${currentData.etudiant} - ${currentData.classe} - ${currentData.matiere}`);
        $('#edit_note').val(currentData.note);
        $('#edit_type_evaluation').val(currentData.type);
        
        // Conversion de la date du format français vers le format HTML (YYYY-MM-DD)
        const dateStr = currentData.date;
        let formattedDate = '';
        if (dateStr && dateStr.includes('/')) {
            const parts = dateStr.split('/');
            if (parts.length === 3) {
                formattedDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
            }
        }
        $('#edit_date_evaluation').val(formattedDate);
        
        $('#editNoteModal').modal('show');
    });

    // Envoi de la modification
    $('#editNoteForm').submit(function(e) {
        e.preventDefault();
        
        const noteId = $('#edit_note_id').val();
        const submitBtn = $(this).find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mise à jour...');
        
        const formData = {
            note: $('#edit_note').val(),
            type_evaluation: $('#edit_type_evaluation').val(),
            date_evaluation: $('#edit_date_evaluation').val(),
            _method: 'PUT',
            _token: $('meta[name="csrf-token"]').attr('content')
        };
        
        $.ajax({
            url: `{{ route('enseignant.notes.update', '') }}/${noteId}`,
            method: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    $('#editNoteModal').modal('hide');
                    showAlert('success', response.message);
                    setTimeout(() => location.reload(), 1500);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Erreur lors de la modification';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert('danger', errorMsg);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Sauvegarder');
            }
        });
    });
    
    // Suppression d'une note
    $(document).on('click', '.delete-note', function() {
        const noteId = $(this).data('id');
        const etudiantNom = $(this).data('etudiant');
        
        if(confirm(`Êtes-vous sûr de vouloir supprimer la note de ${etudiantNom} ?`)) {
            $.ajax({
                url: `{{ route('enseignant.notes.delete', '') }}/${noteId}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success) {
                        $(`#row-${noteId}`).fadeOut(300, function() {
                            $(this).remove();
                            // Vérifier s'il reste des lignes
                            if ($('#resultatsTable tr:visible').length === 0) {
                                setTimeout(() => location.reload(), 500);
                            }
                        });
                        showAlert('success', response.message);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Erreur lors de la suppression';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showAlert('danger', errorMsg);
                }
            });
        }
    });
    
    // Suppression en lot
    window.deleteSelected = function() {
        const selected = $('.row-checkbox:checked').map(function() {
            return this.value;
        }).get();
        
        if (selected.length === 0) {
            showAlert('warning', 'Aucune note sélectionnée');
            return;
        }
        
        if (confirm(`Êtes-vous sûr de vouloir supprimer ${selected.length} note(s) ?`)) {
            $.ajax({
                url: '{{ route("enseignant.delete-multiple-notes") }}',
                method: 'POST',
                data: {
                    ids: selected,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Supprimer les lignes sélectionnées
                        selected.forEach(function(id) {
                            $(`#row-${id}`).fadeOut(300, function() {
                                $(this).remove();
                            });
                        });
                        
                        // Réinitialiser les cases à cocher
                        $('#selectAll').prop('checked', false);
                        toggleBulkActions();
                        
                        showAlert('success', response.message);
                        
                        // Recharger si plus de résultats
                        setTimeout(() => {
                            if ($('#resultatsTable tr:visible').length === 0) {
                                location.reload();
                            }
                        }, 500);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Erreur lors de la suppression';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showAlert('danger', errorMsg);
                }
            });
        }
    };
    
    // Fonction d'affichage des alertes
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'success' : type === 'danger' ? 'danger' : 'warning';
        const iconClass = type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle';
        
        const alert = `
            <div class="alert alert-${alertClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas fa-${iconClass}"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('body').append(alert);
        
        setTimeout(function() {
            $('.alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Fonction pour effacer la recherche
    window.clearSearch = function() {
        $('#searchForm')[0].reset();
        window.location.href = window.location.pathname;
    };
    
    // Réinitialiser le formulaire d'ajout rapide quand le modal se ferme
    $('#quickNoteModal').on('hidden.bs.modal', function() {
        $('#quickNoteForm')[0].reset();
        $('#quick_matiere_id').html('<option value="">-- Choisir une matière --</option>');
        $('#quick_etudiant_id').html('<option value="">-- Choisir un étudiant --</option>');
    });
    
    // Réinitialiser le formulaire de modification quand le modal se ferme
    $('#editNoteModal').on('hidden.bs.modal', function() {
        $('#editNoteForm')[0].reset();
    });
});
</script>
<style>
.badge-danger { background-color: #dc3545; }
.badge-warning { background-color: #ffc107; color: #212529; }
.badge-info { background-color: #17a2b8; }
.badge { 
    padding: 0.25em 0.6em;
    font-size: 75%;
    font-weight: 700;
    border-radius: 0.25rem;
    color: white;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.075);
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.card-header h5 {
    margin-bottom: 0;
}

.position-fixed {
    position: fixed !important;
}

.row-checkbox {
    transform: scale(1.2);
}

#selectAll {
    transform: scale(1.2);
}

.fw-bold {
    font-weight: bold !important;
}

.text-center h5 {
    color: #6c757d;
}

.alert-info {
    border-left: 4px solid #17a2b8;
}

.table th {
    font-weight: 600;
    color: #495057;
    border-bottom: 2px solid #dee2e6;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}

.modal-header {
    border-top-left-radius: calc(0.375rem - 1px);
    border-top-right-radius: calc(0.375rem - 1px);
}

.form-control:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-group {
    gap: 2px;
}

.spinner-border {
    width: 1rem;
    height: 1rem;
}

.collapse.show {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.table-responsive {
    border-radius: 0.375rem;
}

#bulkActions {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-body {
    padding: 1.5rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.modal-lg {
    max-width: 800px;
}

.text-muted {
    color: #6c757d !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.me-2 {
    margin-right: 0.5rem !important;
}

.ms-1 {
    margin-left: 0.25rem !important;
}

.ms-2 {
    margin-left: 0.5rem !important;
}

.mt-2 {
    margin-top: 0.5rem !important;
}

.mt-3 {
    margin-top: 1rem !important;
}

.mb-3 {
    margin-bottom: 1rem !important;
}

.mb-4 {
    margin-bottom: 1.5rem !important;
}

.float-end {
    float: right !important;
}

.d-flex {
    display: flex !important;
}

.justify-content-center {
    justify-content: center !important;
}

.align-items-end {
    align-items: flex-end !important;
}

.visually-hidden {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}
</style>

@endsection