@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête avec titre et stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2 text-gray-800">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Gestion des Notes
                    </h1>
                    <p class="text-muted mb-0">Consultez et gérez les notes des étudiants</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary fs-6">
                        Total: {{ $notations->count() }} notes
                    </span>
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
                <div class="col-md-6">
                    <label for="search_matiere" class="form-label">
                        <i class="fas fa-search me-1"></i>
                        Rechercher par matière
                    </label>
                    <input type="text" 
                           class="form-control form-control-lg" 
                           id="search_matiere" 
                           name="search_matiere" 
                           value="{{ request('search_matiere') }}"
                           placeholder="Tapez le nom de la matière..."
                           autocomplete="off">
                </div>
                <div class="col-md-4">
                    <label for="annee_scolaire" class="form-label">
                        <i class="fas fa-calendar me-1"></i>
                        Année scolaire
                    </label>
                    <select class="form-select form-select-lg" name="annee_scolaire" id="annee_scolaire">
                        <option value="">Toutes les années</option>
                        @php
                            $annees = $notations->pluck('annee_scolaire')->unique()->sort();
                        @endphp
                        @foreach($annees as $annee)
                            <option value="{{ $annee }}" {{ request('annee_scolaire') == $annee ? 'selected' : '' }}>
                                {{ $annee }}
                            </option>
                        @endforeach
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

    <!-- Tableau des notes -->
    <div class="card shadow">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table me-2"></i>
                    Liste des Notes
                </h5>
                @if(request()->hasAny(['search_matiere', 'annee_scolaire']))
                    <small class="opacity-75">
                        Résultats filtrés: {{ $notations->count() }} notes
                    </small>
                @endif
            </div>
        </div>
        
        <div class="card-body p-0">
            @if ($notations->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-clipboard-list fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Aucune note trouvée</h5>
                    <p class="text-muted mb-3">
                        @if(request()->hasAny(['search_matiere', 'annee_scolaire']))
                            Aucune note ne correspond à vos critères de recherche.
                        @else
                            Aucune note n'a été enregistrée pour le moment.
                        @endif
                    </p>
                    @if(request()->hasAny(['search_matiere', 'annee_scolaire']))
                        <a href="{{ request()->url() }}" class="btn btn-outline-primary">
                            <i class="fas fa-undo me-1"></i>
                            Afficher toutes les notes
                        </a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%">#</th>
                                <th scope="col" style="width: 25%">
                                    <i class="fas fa-user me-1"></i>
                                    Étudiant
                                </th>
                                <th scope="col" style="width: 20%">
                                    <i class="fas fa-book me-1"></i>
                                    Matière
                                </th>
                                <th scope="col" class="text-center" style="width: 15%">
                                    <i class="fas fa-star me-1"></i>
                                    Note
                                </th>
                                <th scope="col" class="text-center" style="width: 15%">
                                    <i class="fas fa-calendar me-1"></i>
                                    Date
                                </th>
                                <th scope="col" class="text-center" style="width: 20%">
                                    <i class="fas fa-graduation-cap me-1"></i>
                                    Année scolaire
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notations as $index => $notation)
                                <tr class="align-middle">
                                    <td class="text-center fw-bold text-muted">
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div>
                                                @if ($notation->etudiant)
                                                    <div class="fw-bold text-dark">
                                                        {{ $notation->etudiant->nom }} {{ $notation->etudiant->prenom }}
                                                    </div>
                                                @else
                                                    <span class="text-muted fst-italic">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Étudiant inconnu
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($notation->matiere)
                                            <span class="badge bg-info bg-gradient px-3 py-2">
                                                {{ $notation->matiere->nomM }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-question me-1"></i>
                                                Matière inconnue
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $note = $notation->note;
                                            $class = '';
                                            if ($note >= 16) $class = 'text-success';
                                            elseif ($note >= 12) $class = 'text-info';
                                            elseif ($note >= 10) $class = 'text-warning';
                                            else $class = 'text-danger';
                                        @endphp
                                        <span class="badge fs-6 px-3 py-2 {{ $note >= 16 ? 'bg-success' : ($note >= 12 ? 'bg-info' : ($note >= 10 ? 'bg-warning' : 'bg-danger')) }}">
                                            {{ $notation->note }}/20
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($notation->dateEv)->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-outline-primary border border-primary text-primary">
                                            {{ $notation->annee_scolaire }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when typing in search field
    const searchInput = document.getElementById('search_matiere');
    const searchForm = searchInput.closest('form');
    let timeoutId;

    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
            searchForm.submit();
        }, 500); // Attendre 500ms après la dernière frappe
    });

    // Auto-submit form when changing year
    const yearSelect = document.getElementById('annee_scolaire');
    yearSelect.addEventListener('change', function() {
        searchForm.submit();
    });
});
</script>
@endsection