@extends('layouts.enseignant')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2 text-gray-800 fw-bold">
                        <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                        Mes Classes
                    </h1>
                    <p class="text-muted mb-0">Gérez vos classes et consultez vos étudiants</p>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary fs-6 px-3 py-2">
                        {{ $classes->count() }} {{ $classes->count() > 1 ? 'Classes' : 'Classe' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Classes Grid/Table -->
    <div class="row">
        <div class="col-12">
            @if($classes->count() > 0)
                <!-- Desktop Table View -->
                <div class="card border-0 shadow-sm d-none d-lg-block">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark fw-semibold">
                            <i class="fas fa-list me-2 text-primary"></i>
                            Liste des Classes
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 py-3 px-4 fw-semibold text-dark">
                                            <i class="fas fa-school me-2"></i>Classe
                                        </th>
                                        <th class="border-0 py-3 px-4 fw-semibold text-dark">
                                            <i class="fas fa-layer-group me-2"></i>Niveau
                                        </th>
                                        <th class="border-0 py-3 px-4 fw-semibold text-dark">
                                            <i class="fas fa-book me-2"></i>Matière
                                        </th>
                                        <th class="border-0 py-3 px-4 fw-semibold text-dark text-center">
                                            <i class="fas fa-users me-2"></i>Étudiants
                                        </th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classes as $classe)
                                        <tr class="border-bottom">
                                            <td class="py-3 px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                        <i class="fas fa-chalkboard text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $classe->nom_classe }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                                    {{ $classe->niveau }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                                    {{ $classe->nom_matiere }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="fas fa-user-graduate text-warning"></i>
                                                    </div>
                                                    <span class="fw-semibold fs-5">{{ $classe->etudiants_count }}</span>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="d-block d-lg-none">
                    @foreach($classes as $classe)
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-3 text-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-flex">
                                            <i class="fas fa-chalkboard text-primary fs-4"></i>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <h5 class="card-title mb-2 fw-bold">{{ $classe->nom_classe }}</h5>
                                        <div class="mb-2">
                                            <span class="badge bg-info bg-opacity-10 text-info me-2 px-2 py-1">
                                                <i class="fas fa-layer-group me-1"></i>{{ $classe->niveau }}
                                            </span>
                                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">
                                                <i class="fas fa-book me-1"></i>{{ $classe->nom_matiere }}
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-users me-2"></i>
                                                <span class="fw-semibold">{{ $classe->etudiants_count }} étudiants</span>
                                            </div>
                                            <a href="{{ route('enseignant.add-result', ['classe_id' => $classe->idClasse]) }}" 
                                               class="btn btn-primary btn-sm rounded-pill px-3">
                                                <i class="fas fa-eye me-1"></i>Voir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-chalkboard-teacher text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                        <h4 class="text-muted mb-3">Aucune classe assignée</h4>
                        <p class="text-muted mb-4">
                            Vous n'avez actuellement aucune classe assignée. 
                            Contactez l'administration pour plus d'informations.
                        </p>
                        <button class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-envelope me-2"></i>
                            Contacter l'administration
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Statistics Cards (Optional) -->
    @if($classes->count() > 0)
        <div class="row mt-4">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-white-50 mb-1">Total Classes</h6>
                                <h3 class="mb-0 fw-bold">{{ $classes->count() }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chalkboard fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-white-50 mb-1">Total Étudiants</h6>
                                <h3 class="mb-0 fw-bold">{{ $classes->sum('etudiants_count') }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card border-0 shadow-sm bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-white-50 mb-1">Matières</h6>
                                <h3 class="mb-0 fw-bold">{{ $classes->unique('nom_matiere')->count() }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-book fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Custom CSS for additional styling */
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-1px);
    transition: all 0.2s ease;
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.card {
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-weight: 500;
}

.bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

/* Custom animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeIn 0.5s ease-out;
}

/* Mobile responsiveness improvements */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    h1 {
        font-size: 1.5rem !important;
    }
    
    .badge {
        font-size: 0.75rem;
    }
}
</style>
@endsection