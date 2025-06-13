@extends('layouts.enseignant')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Ajouter des Notes</h3>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Erreurs de validation :</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('enseignant.store-result') }}" method="POST" id="notesForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="classe_id">Classe *</label>
                                    <select name="classe_id" id="classeSelect" class="form-control" required>
                                        <option value="">-- Sélectionner une classe --</option>
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->idClasse }}" 
                                                {{ (old('classe_id') ?? request('classe_id')) == $classe->idClasse ? 'selected' : '' }}>
                                                {{ $classe->nomClasse }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="matiere_id">Matière *</label>
                                    <select name="matiere_id" id="matiereSelect" class="form-control" required>
    <option value="">-- Sélectionner une matière --</option>
    @foreach($matieres as $matiere)
        <option value="{{ $matiere->idMatiere }}" 
            {{ old('matiere_id', $selectedMatiere) == $matiere->idMatiere ? 'selected' : '' }}>
            {{ $matiere->nomM}}
        </option>
    @endforeach
</select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="date_evaluation">Date d'évaluation *</label>
                                    <input type="date" name="date_evaluation" id="date_evaluation" class="form-control" 
                                           value="{{ old('date_evaluation', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type_evaluation">Type d'évaluation *</label>
                                    <select name="type_evaluation" id="type_evaluation" class="form-control" required>
                                        <option value="Contrôle" {{ old('type_evaluation') == 'Contrôle' ? 'selected' : '' }}>Contrôle</option>
                                        <option value="Devoir" {{ old('type_evaluation') == 'Devoir' ? 'selected' : '' }}>Devoir</option>
                                        <option value="Examen" {{ old('type_evaluation') == 'Examen' ? 'selected' : '' }}>Examen</option>
                                        <option value="Participation" {{ old('type_evaluation') == 'Participation' ? 'selected' : '' }}>Participation</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="etudiantsContainer" class="mt-4">
                            @if($etudiants && $etudiants->count() > 0)
                                <div class="alert alert-info">
                                    <strong>Classe sélectionnée :</strong> {{ $classes->where('idClasse', request('classe_id'))->first()->nomClasse ?? '' }}
                                    <br><strong>Nombre d'étudiants :</strong> {{ $etudiants->count() }}
                                </div>
                                
                                <h5>Notes des étudiants</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="50%">Étudiant</th>
                                                <th width="30%">Note (0-20)</th>
                                                <th width="20%">Appréciation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($etudiants as $index => $etudiant)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $etudiant->nom }} {{ $etudiant->prenom }}</strong>
                                                        <input type="hidden" name="etudiant_id[]" value="{{ $etudiant->idEtu }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" 
                                                               name="note[]" 
                                                               class="form-control note-input" 
                                                               min="0" 
                                                               max="20" 
                                                               step="0.25" 
                                                               placeholder="0.00"
                                                               value="{{ old('note.' . $index) }}"
                                                               required>
                                                    </td>
                                                    <td>
                                                        <span class="appreciation-badge" data-index="{{ $index }}"></span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-save"></i> Enregistrer les notes
                                    </button>
                                    <a href="{{ route('enseignant.resultats') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left"></i> Retour
                                    </a>
                                    <button type="button" class="btn btn-info btn-lg" onclick="calculateStats()">
                                        <i class="fas fa-calculator"></i> Calculer les statistiques
                                    </button>
                                </div>

                                <div id="statistiques" class="mt-3" style="display: none;">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Statistiques de la classe</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h6>Moyenne</h6>
                                                        <span id="moyenne" class="badge badge-primary badge-lg">-</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h6>Note Max</h6>
                                                        <span id="noteMax" class="badge badge-success badge-lg">-</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h6>Note Min</h6>
                                                        <span id="noteMin" class="badge badge-warning badge-lg">-</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h6>Taux de réussite</h6>
                                                        <span id="tauxReussite" class="badge badge-info badge-lg">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Information :</strong> Veuillez sélectionner une classe pour voir la liste des étudiants.
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Gestion du changement de classe
    $('#classeSelect').change(function() {
        var classeId = $(this).val();
        if (classeId) {
            // Conserver les autres valeurs du formulaire
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('classe_id', classeId);
            window.location.href = currentUrl.toString();
        } else {
            // Supprimer le paramètre classe_id si aucune classe sélectionnée
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.delete('classe_id');
            window.location.href = currentUrl.toString();
        }
    });

    // Calcul automatique de l'appréciation
    $('.note-input').on('input', function() {
        var note = parseFloat($(this).val());
        var index = $(this).closest('tr').find('.appreciation-badge').data('index');
        var appreciationElement = $('[data-index="' + index + '"]');
        
        if (!isNaN(note)) {
            var appreciation = getAppreciation(note);
            appreciationElement.text(appreciation.text)
                             .removeClass()
                             .addClass('badge badge-' + appreciation.class);
        } else {
            appreciationElement.text('').removeClass();
        }
    });

    // Validation du formulaire
    $('#notesForm').on('submit', function(e) {
        var hasEmptyNotes = false;
        $('.note-input').each(function() {
            if (!$(this).val() || $(this).val() === '') {
                hasEmptyNotes = true;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (hasEmptyNotes) {
            e.preventDefault();
            alert('Veuillez saisir toutes les notes avant de soumettre le formulaire.');
        }
    });
});

function getAppreciation(note) {
    if (note >= 16) return {text: 'Excellent', class: 'success'};
    if (note >= 14) return {text: 'Très bien', class: 'info'};
    if (note >= 12) return {text: 'Bien', class: 'primary'};
    if (note >= 10) return {text: 'Assez bien', class: 'warning'};
    return {text: 'Insuffisant', class: 'danger'};
}

function calculateStats() {
    var notes = [];
    $('.note-input').each(function() {
        var note = parseFloat($(this).val());
        if (!isNaN(note)) {
            notes.push(note);
        }
    });

    if (notes.length === 0) {
        alert('Veuillez saisir au moins une note pour calculer les statistiques.');
        return;
    }

    var somme = notes.reduce((a, b) => a + b, 0);
    var moyenne = (somme / notes.length).toFixed(2);
    var noteMax = Math.max(...notes).toFixed(2);
    var noteMin = Math.min(...notes).toFixed(2);
    var reussites = notes.filter(note => note >= 10).length;
    var tauxReussite = ((reussites / notes.length) * 100).toFixed(1);

    $('#moyenne').text(moyenne + '/20');
    $('#noteMax').text(noteMax + '/20');
    $('#noteMin').text(noteMin + '/20');
    $('#tauxReussite').text(tauxReussite + '%');

    $('#statistiques').slideDown();
}
</script>
@endsection