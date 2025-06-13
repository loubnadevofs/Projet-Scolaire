@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Header avec icône -->
            <div class="text-center mb-5">
                <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-user-edit text-white fs-4"></i>
                </div>
                <h2 class="fw-bold text-dark mb-2">Modifier le Formateur</h2>
                <p class="text-muted">Mettez à jour les informations du formateur</p>
            </div>

            <!-- Carte du formulaire -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <form action="{{ route('admin.enseignants.update', $enseignant->idEnsei) }}" method="POST">
                        @csrf 
                        @method('PUT')
                        
                        <!-- Nom -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-user me-2 text-primary"></i>Nom
                            </label>
                            <input type="text" 
                                   name="nom" 
                                   class="form-control form-control-lg rounded-3 border-2" 
                                   value="{{ $enseignant->nom }}" 
                                   required
                                   style="border-color: #e9ecef; transition: all 0.3s ease;"
                                   onfocus="this.style.borderColor='#0d6efd'; this.style.boxShadow='0 0 0 0.2rem rgba(13, 110, 253, 0.25)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                        </div>

                        <!-- Prénom -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-user me-2 text-primary"></i>Prénom
                            </label>
                            <input type="text" 
                                   name="prenom" 
                                   class="form-control form-control-lg rounded-3 border-2" 
                                   value="{{ $enseignant->prenom }}" 
                                   required
                                   style="border-color: #e9ecef; transition: all 0.3s ease;"
                                   onfocus="this.style.borderColor='#0d6efd'; this.style.boxShadow='0 0 0 0.2rem rgba(13, 110, 253, 0.25)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-envelope me-2 text-primary"></i>Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control form-control-lg rounded-3 border-2" 
                                   value="{{ $enseignant->email }}" 
                                   required
                                   style="border-color: #e9ecef; transition: all 0.3s ease;"
                                   onfocus="this.style.borderColor='#0d6efd'; this.style.boxShadow='0 0 0 0.2rem rgba(13, 110, 253, 0.25)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-5">
                            <label class="form-label fw-semibold text-dark mb-2">
                                <i class="fas fa-lock me-2 text-primary"></i>Mot de passe
                            </label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control form-control-lg rounded-3 border-2" 
                                   placeholder="Laisser vide si inchangé"
                                   style="border-color: #e9ecef; transition: all 0.3s ease;"
                                   onfocus="this.style.borderColor='#0d6efd'; this.style.boxShadow='0 0 0 0.2rem rgba(13, 110, 253, 0.25)'"
                                   onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Laissez ce champ vide pour conserver le mot de passe actuel
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('admin.enseignants.index') }}" 
                               class="btn btn-outline-secondary btn-lg px-4 rounded-3">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" 
                                    class="btn btn-primary btn-lg px-4 rounded-3 shadow-sm"
                                    style="background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%); border: none;">
                                <i class="fas fa-save me-2"></i>Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Note informative -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt me-1"></i>
                    Toutes les modifications seront sauvegardées de manière sécurisée
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    .container {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        min-height: 100vh;
    }
    
    .card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
    }
    
    .form-control:focus {
        transform: translateY(-1px);
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3) !important;
    }
    
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
    
    @media (max-width: 768px) {
        .card-body {
            padding: 2rem !important;
        }
        
        .d-flex.gap-3 {
            flex-direction: column;
        }
        
        .d-flex.gap-3 .btn {
            width: 100%;
        }
    }
</style>
@endsection