<!-- resources/views/etudiants/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Ajout d\'un Étudiant')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="bg-success bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-user-graduate text-white fs-3"></i>
                </div>
                <h2 class="fw-bold text-dark mb-2">Ajouter un Nouvel Étudiant</h2>
                <p class="text-muted">Renseignez les informations de l'étudiant</p>
            </div>

            <!-- Main Card -->
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Card Header with gradient -->
                <div class="card-header bg-gradient text-white py-4" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-plus-circle me-3 fs-4"></i>
                        <h3 class="mb-0 fw-semibold">Informations de l'Étudiant</h3>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-5" style="background: linear-gradient(135deg, #f8fffe 0%, #e8f5f0 100%);">
                    <form action="{{ route('admin.etudiants.store') }}" method="POST">
                        @csrf
                        
                        <!-- Row for Name fields -->
                        <div class="row mb-4">
                            <!-- Nom -->
                            <div class="col-md-6">
                                <label for="nom" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-user me-2 text-success"></i>Nom
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg rounded-3 border-2 @error('nom') is-invalid border-danger @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom') }}" 
                                       required
                                       style="border-color: #e9ecef; transition: all 0.3s ease;"
                                       onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 0.2rem rgba(40, 167, 69, 0.25)'"
                                       onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                @error('nom')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div class="col-md-6">
                                <label for="prenom" class="form-label fw-semibold text-dark mb-2">
                                    <i class="fas fa-user me-2 text-success"></i>Prénom
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg rounded-3 border-2 @error('prenom') is-invalid border-danger @enderror" 
                                       id="prenom" 
                                       name="prenom" 
                                       value="{{ old('prenom') }}" 
                                       required
                                       style="border-color: #e9ecef; transition: all 0.3s ease;"
                                       onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 0.2rem rgba(40, 167, 69, 0.25)'"
                                       onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                @error('prenom')
                                    <div class="invalid-feedback d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Classe -->
                        <div class="mb-4">
                            <label for="idClasse" class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-school me-2 text-success"></i>Classe
                            </label>
                            <select class="form-select form-select-lg rounded-3 border-2 @error('idClasse') is-invalid border-danger @enderror" 
                                    id="idClasse" 
                                    name="idClasse" 
                                    required
                                    style="border-color: #e9ecef; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 0.2rem rgba(40, 167, 69, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                <option value="">🎓 Sélectionner une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->idClasse }}" {{ old('idClasse') == $classe->idClasse ? 'selected' : '' }}>
                                        📚 {{ $classe->nom }} ({{ $classe->niveau }})
                                    </option>
                                @endforeach
                            </select>
                            @error('idClasse')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Date de naissance -->
                        <div class="mb-5">
                            <label for="dateNaissance" class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-calendar-alt me-2 text-success"></i>Date de naissance
                            </label>
                            <input type="date" 
                                   class="form-control form-control-lg rounded-3 border-2 @error('dateNaissance') is-invalid border-danger @enderror" 
                                   id="dateNaissance" 
                                   name="dateNaissance" 
                                   value="{{ old('dateNaissance') }}" 
                                   required
                                   style="border-color: #e9ecef; transition: all 0.3s ease;"
                                   onfocus="this.style.borderColor='#28a745'; this.style.boxShadow='0 0 0 0.2rem rgba(40, 167, 69, 0.25)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                            @error('dateNaissance')
                                <div class="invalid-feedback d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between gap-3">
                            <a href="{{ route('admin.etudiants.index') }}" 
                               class="btn btn-outline-secondary btn-lg px-4 rounded-3 flex-fill flex-md-fill-0">
                                <i class="fas fa-arrow-left me-2"></i>Annuler
                            </a>
                            <button type="submit" 
                                    class="btn btn-success btn-lg px-4 rounded-3 shadow-sm flex-fill flex-md-fill-0"
                                    style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none;">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Footer -->
            <div class="text-center mt-4">
                <div class="alert alert-info border-0 rounded-3 d-inline-block" style="background: rgba(13, 202, 240, 0.1);">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    <small>Tous les champs marqués sont obligatoires pour l'inscription</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        min-height: 100vh;
    }
    
    .card {
        backdrop-filter: blur(10px);
    }
    
    .form-control:focus,
    .form-select:focus {
        transform: translateY(-1px);
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3) !important;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
        transition: all 0.3s ease;
    }
    
    .invalid-feedback {
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .form-select option {
        padding: 10px;
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .row.mb-4 {
            margin-bottom: 1rem !important;
        }
        
        .col-md-6 {
            margin-bottom: 1rem;
        }
    }
    
    /* Animation pour les champs valides */
    .form-control:valid,
    .form-select:valid {
        border-color: #28a745;
    }
    
    .form-control:valid:focus,
    .form-select:valid:focus {
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
</style>
@endsection