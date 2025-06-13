@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="bg-info bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="fas fa-chalkboard-teacher text-white fs-2"></i>
                </div>
                <h2 class="fw-bold text-dark mb-2">Détails du Formateur</h2>
                <p class="text-muted">Informations complètes du formateur</p>
            </div>

            <!-- Main Profile Card -->
            <div class="card border-0 shadow-lg rounded-4 mb-4">
                <div class="card-header bg-gradient text-white py-4" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
                    <div class="d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 rounded-circle p-3 me-3">
                            <i class="fas fa-user-tie text-white fs-4"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-semibold">{{ $enseignant->nom }} {{ $enseignant->prenom }}</h3>
                            <p class="mb-0 opacity-75">Formateur</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5" style="background: linear-gradient(135deg, #f8fdff 0%, #e8f7fa 100%);">
                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-item p-4 rounded-3 h-100" style="background: rgba(23, 162, 184, 0.05); border-left: 4px solid #17a2b8;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-user text-info me-3 fs-5"></i>
                                    <strong class="text-dark">Nom:</strong>
                                </div>
                                <p class="mb-0 fs-5 text-dark">{{ $enseignant->nom }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <div class="info-item p-4 rounded-3 h-100" style="background: rgba(23, 162, 184, 0.05); border-left: 4px solid #17a2b8;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-user text-info me-3 fs-5"></i>
                                    <strong class="text-dark">Prénom:</strong>
                                </div>
                                <p class="mb-0 fs-5 text-dark">{{ $enseignant->prenom }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <div class="info-item p-4 rounded-3 h-100" style="background: rgba(23, 162, 184, 0.05); border-left: 4px solid #17a2b8;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope text-info me-3 fs-5"></i>
                                    <strong class="text-dark">Email:</strong>
                                </div>
                                <p class="mb-0 fs-5">
                                    <a href="mailto:{{ $enseignant->email }}" class="text-decoration-none text-info">
                                        {{ $enseignant->email }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subjects and Classes Row -->
            <div class="row">
                <!-- Matières enseignées -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-header bg-gradient text-white py-4" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-book-open me-3 fs-4"></i>
                                <h4 class="mb-0 fw-semibold">Matières enseignées :</h4>
                            </div>
                        </div>
                        <div class="card-body p-4" style="background: linear-gradient(135deg, #f8fff8 0%, #e8f5e8 100%);">
                            @if($enseignant->matieres->count() > 0)
                                <ul class="list-unstyled mb-0">
                                    @foreach($enseignant->matieres as $matiere)
                                        <li class="d-flex align-items-center mb-3 p-3 rounded-3" style="background: rgba(40, 167, 69, 0.1);">
                                            <div class="bg-success bg-opacity-20 rounded-circle p-2 me-3">
                                                <i class="fas fa-graduation-cap text-success"></i>
                                            </div>
                                            <span class="fw-medium text-dark">{{ $matiere->nomM }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-book-open text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted mb-0">Aucune matière assignée</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Classes assignées -->
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-header bg-gradient text-white py-4" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users me-3 fs-4"></i>
                                <h4 class="mb-0 fw-semibold">Classes assignées :</h4>
                            </div>
                        </div>
                        <div class="card-body p-4" style="background: linear-gradient(135deg, #fffef8 0%, #fff8e1 100%);">
                            <ul class="list-unstyled mb-0">
                                @forelse($enseignant->classes as $classe)
                                    <li class="d-flex align-items-center mb-3 p-3 rounded-3" style="background: rgba(255, 193, 7, 0.1);">
                                        <div class="bg-warning bg-opacity-20 rounded-circle p-2 me-3">
                                            <i class="fas fa-school text-warning"></i>
                                        </div>
                                        <span class="fw-medium text-dark">{{ $classe->nom ?? 'Nom non défini' }}</span>
                                    </li>
                                @empty
                                    <li class="text-center py-4">
                                        <i class="fas fa-users text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                        <p class="text-muted mb-0">Aucune classe assignée.</p>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="text-center mt-4">
                <a href="{{route('admin.enseignants.index')}}" 
                   class="btn btn-secondary btn-lg px-5 rounded-3 shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Dernière mise à jour des informations
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
        min-height: 100vh;
    }
    
    .card {
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }
    
    .info-item {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(23, 162, 184, 0.15);
        border-color: rgba(23, 162, 184, 0.2);
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    }
    
    .list-unstyled li {
        transition: all 0.3s ease;
    }
    
    .list-unstyled li:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        
        .card-body {
            padding: 2rem !important;
        }
        
        .row.mb-4 .col-md-4 {
            margin-bottom: 1rem;
        }
        
        .fs-2 {
            font-size: 1.5rem !important;
        }
        
        .fs-4 {
            font-size: 1.2rem !important;
        }
    }
    
    /* Animation pour les icônes */
    .fas {
        transition: transform 0.3s ease;
    }
    
    .card:hover .fas {
        transform: scale(1.1);
    }
</style>
@endsection