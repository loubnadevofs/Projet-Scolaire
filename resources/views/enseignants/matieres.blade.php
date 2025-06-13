@extends('layouts.enseignant')
@section('title', 'Mes Matières')
@section('content')

<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1 fw-bold text-primary">
                <i class="fas fa-book-open me-2"></i>Mes Matières
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('enseignant.dashboard') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Matières</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('enseignant.dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <!-- Total Matières Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-start border-primary border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Total Matières</h6>
                             <h2 class="mb-0 text-primary">{{ $matieres->count() }}</h2>
                        </div>
                        <div class="icon-circle bg-primary-light">
                            <i class="fas fa-book text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Coefficients Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-start border-success border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Total Coefficients</h6>
                            <h2 class="mb-0 text-success">{{ $matieres->sum('coefficient') }}</h2>
                        </div>
                        <div class="icon-circle bg-success-light">
                            <i class="fas fa-weight-hanging text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Coefficient Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-start border-info border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Moy. Coefficient</h6>
                            <h2 class="mb-0 text-info">{{ number_format($matieres->avg('coefficient'), 1) }}</h2>
                        </div>
                        <div class="icon-circle bg-info-light">
                            <i class="fas fa-calculator text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Highest Coefficient Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-start border-warning border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted mb-2">Max. Coefficient</h6>
                            <h2 class="mb-0 text-warning">{{ $matieres->max('coefficient') }}</h2>
                        </div>
                        <div class="icon-circle bg-warning-light">
                            <i class="fas fa-arrow-up text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Matières Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-semibold">
                            <i class="fas fa-list-ul me-2 text-muted"></i>Liste de mes matières
                        </h5>
                        <span class="badge bg-primary rounded-pill">
                            {{ $matieres->count() }} Matière(s)
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($matieres->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">#</th>
                                        <th>Matière</th>
                                        <th width="120">Coefficient</th>
                                        <th>Description</th>
                                        <th width="150" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($matieres as $index => $matiere)
                                    <tr>
                                        <td class="fw-medium">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-circle-sm bg-primary-light me-3">
                                                    <i class="fas fa-book text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold">{{ $matiere->nomM }}</h6>
                                                    <small class="text-muted">Code: MAT-{{ str_pad($matiere->idMatiere, 3, '0', STR_PAD_LEFT) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                {{ $matiere->coefficient }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(isset($matiere->description))
                                                <p class="mb-0 text-muted" data-bs-toggle="tooltip" title="{{ $matiere->description }}">
                                                    {{ Str::limit($matiere->description, 50) }}
                                                </p>
                                            @else
                                                <span class="text-muted">Aucune description</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('enseignant.resultats', $matiere->idMatiere) }}" 
                                                   class="btn btn-outline-primary rounded-start-2" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Voir les résultats">
                                                    <i class="fas fa-chart-bar"></i>
                                                </a>
                                                <a href="{{ route('enseignant.absences', $matiere->idMatiere) }}" 
                                                   class="btn btn-outline-warning" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Gérer les absences">
                                                    <i class="fas fa-calendar-times"></i>
                                                </a>
                                                <button class="btn btn-outline-secondary rounded-end-2" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Plus d'options">
                                                    <i class="fas fa-ellipsis-h"></i>
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
                            <div class="mb-4">
                                <i class="fas fa-book-open fa-4x text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted mb-3">Aucune matière assignée</h5>
                            <p class="text-muted mb-4">Vous n'avez actuellement aucune matière assignée à votre compte.</p>
                            <a href="{{ route('enseignant.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>Retour au tableau de bord
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .stat-card {
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .icon-circle-sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1);
    }
    
    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .border-start {
        border-left-width: 4px !important;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
        font-size: 0.875rem;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
</style>
@endsection

@section('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection