@extends('layouts.enseignant')
@section('title', 'Tableau de bord')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle shadow-sm" type="button" id="dropdownActions" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bolt me-2"></i>Actions rapides
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownActions">
                <li><a class="dropdown-item" href="{{ route('enseignant.resultats') }}"><i class="fas fa-plus-circle me-2"></i>Ajouter des résultats</a></li>

            </ul>
        </div>
    </div>

    <!-- Cards Row -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-lg border-start-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-primary fw-bold mb-1">Mes Matières</h6>
                            @if(isset($matieres))
                                <h2 class="mb-0 fw-bold">{{ $matieres->count() }}</h2>
                            @else
                                <h2 class="mb-0 fw-bold">0</h2>
                            @endif
                        </div>
                        <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('enseignant.matieres') }}" class="text-decoration-none d-flex align-items-center">
                        <span>Voir toutes les matières</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-lg border-start-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-success fw-bold mb-1">Mes Classes</h6>
                            <h2 class="mb-0 fw-bold">{{ $classes->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-success bg-opacity-10 text-success rounded-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('enseignant.resultats') }}" class="text-decoration-none d-flex align-items-center">
                        <span>Gérer les classes</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        
        
        
        <div class="col-xl-3 col-md-6">
            <div class="card border-start-lg border-start-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-info fw-bold mb-1">Total Évaluations</h6>
                            <h2 class="mb-0 fw-bold">
                                @if($enseignant->matieres && $enseignant->matieres->count() > 0)
                                    {{ App\Models\Notation::whereIn('idMatiere', $enseignant->matieres->pluck('idMatiere'))->count() }}
                                @else
                                    0
                                @endif
                            </h2>
                        </div>
                        <div class="icon-shape bg-info bg-opacity-10 text-info rounded-3">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('enseignant.resultats') }}" class="text-decoration-none d-flex align-items-center">
                        <span>Voir tous les résultats</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-gray-800">Matières enseignées</h5>
                    <a href="{{ route('enseignant.matieres') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye me-1"></i> Tout voir
                    </a>
                </div>
                <div class="card-body">
                    @if($enseignant->matieres && $enseignant->matieres->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune matière assignée</p>
                        </div>
                    @elseif($enseignant->matieres)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Matière</th>
                                        <th class="border-0">Coefficient</th>
                                        <th class="border-0 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enseignant->matieres->take(5) as $matiere)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle me-3 p-2">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                                <span class="fw-bold">{{ $matiere->nomM }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">{{ $matiere->coefficient }}</span>
                                        </td>
                                        <td class="align-middle text-end">
                                            <a href="#" class="btn btn-sm btn-outline-secondary" title="Détails">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune matière assignée</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-gray-800">Dernières activités</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-history me-1"></i> Voir tout
                    </a>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Timeline Item 1 -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1">Nouvelle évaluation ajoutée</h6>
                                    <small class="text-muted">Il y a 2h</small>
                                </div>
                                <p class="mb-0">Mathématiques - Contrôle n°3</p>
                            </div>
                        </div>
                        <!-- Timeline Item 2 -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1">Absence enregistrée</h6>
                                    <small class="text-muted">Aujourd'hui, 10:45</small>
                                </div>
                                <p class="mb-0">Jean Dupont - Physique</p>
                            </div>
                        </div>
                        <!-- Timeline Item 3 -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1">Note modifiée</h6>
                                    <small class="text-muted">Hier, 16:30</small>
                                </div>
                                <p class="mb-0">Marie Martin - Chimie (12 → 14)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .border-start-lg {
        border-left-width: 0.25rem !important;
    }
    
    .card {
        border-radius: 0.5rem;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .timeline {
        position: relative;
        padding-left: 1rem;
        list-style: none;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        left: 0.5rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    
    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        border: 2px solid white;
        z-index: 1;
    }
    
    .timeline-content {
        padding: 0.75rem 1rem;
        background-color: #f8f9fa;
        border-radius: 0.375rem;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        margin: 0.125rem;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection