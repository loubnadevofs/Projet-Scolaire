@extends('layouts.enseignant')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-users me-2"></i>Liste des Étudiants
        </h2>
        <div class="bg-primary p-2 rounded">
            <span class="text-white">
                <i class="fas fa-chalkboard-teacher me-1"></i> Enseignant: {{ Auth::user()->name }}
            </span>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Students Card -->
        <div class="col-md-4 mb-3">
            <div class="card stat-card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Étudiants</h6>
                            <h3 class="card-title mb-0">{{ $totalStudents }}</h3>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Classes Card -->
        <div class="col-md-4 mb-3">
            <div class="card stat-card bg-success text-white shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Classes</h6>
                            <h3 class="card-title mb-0">{{ $totalClasses }}</h3>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-chalkboard fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Current Class Card -->
        <div class="col-md-4 mb-3">
            <div class="card stat-card bg-info text-dark shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Étudiants dans cette classe</h6>
                            <h3 class="card-title mb-0">
                                {{ $classe_id ? $etudiants->count() : '--' }}
                                @if($classe_id)
                                <small class="fs-6">/{{ $selectedClass->etudiants->count() ?? '' }}</small>
                                @endif
                            </h3>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Card -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-filter me-2 text-secondary"></i>Options de Filtrage
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('enseignant.etudiants') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="classe_id" class="form-label fw-medium">Filtrer par classe:</label>
                        <select name="classe_id" id="classe_id" class="form-select border-2 border-primary" onchange="this.form.submit()">
                            <option value="">-- Toutes les classes --</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->idClasse }}" {{ $classe_id == $classe->idClasse ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} ({{ $classe->etudiants_count }} étudiants)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-search me-1"></i> Appliquer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Students Table -->
    @if($etudiants->isNotEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2 text-secondary"></i>Résultats
                    </h5>
                    <span class="badge bg-primary rounded-pill">
                        {{ $etudiants->count() }} Étudiant(s)
                    </span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">#</th>
                                <th class="py-3">Nom</th>
                                <th class="py-3">Prénom</th>
                                <th class="py-3">Date de Naissance</th>
                                <th class="py-3">Classe</th>
                                <th class="py-3">Âge</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etudiants as $key => $etudiant)
                                <tr class="align-middle">
                                    <td class="fw-medium">{{ $key + 1 }}</td>
                                    <td class="fw-semibold text-dark">{{ $etudiant->nom }}</td>
                                    <td>{{ $etudiant->prenom }}</td>
                                    <td>{{ \Carbon\Carbon::parse($etudiant->dateNaissance)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $etudiant->classe->nom }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ \Carbon\Carbon::parse($etudiant->dateNaissance)->age }} ans
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($etudiants->hasPages())
        <div class="mt-4">
            {{ $etudiants->links('pagination::bootstrap-5') }}
        </div>
        @endif
        
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-graduate fa-4x text-muted mb-4"></i>
                <h4 class="text-muted">
                    @if($classe_id)
                        Aucun étudiant trouvé dans cette classe
                    @else
                        Veuillez sélectionner une classe pour afficher les étudiants
                    @endif
                </h4>
                <p class="text-muted">Essayez de sélectionner une autre classe</p>
            </div>
        </div>
    @endif
</div>

<style>
    /* Custom CSS */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transform: translateX(2px);
        transition: all 0.2s ease;
    }
    
    .card {
        border-radius: 10px;
        border: none;
    }
    
    .stat-card {
        border-radius: 10px;
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .badge {
        font-weight: 500;
        padding: 5px 10px;
    }
    
    .bg-primary {
        background-color: #0d6efd !important;
    }
    
    .bg-success {
        background-color: #198754 !important;
    }
    
    .bg-info {
        background-color: #0dcaf0 !important;
    }
</style>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection