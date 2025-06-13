@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <div class="avatar-lg mx-auto mb-3">
                        <div class="avatar-title bg-primary bg-gradient rounded-circle">
                            <i class="fas fa-user-plus fa-2x text-white"></i>
                        </div>
                    </div>
                    <h2 class="mb-1 text-dark fw-bold">Ajouter un Formateur</h2>
                    <p class="text-muted mb-0">Remplissez les informations ci-dessous pour créer un nouveau compte formateur</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm">
                                <div class="avatar-title bg-light text-primary rounded">
                                    <i class="fas fa-edit"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="card-title mb-1">Informations du Formateur</h5>
                            <p class="text-muted mb-0 small">Tous les champs marqués d'un * sont obligatoires</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.enseignants.store') }}" method="POST" id="formateurForm">
                        @csrf
                        
                        <!-- Nom & Prénom Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="nom" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-user me-2 text-primary"></i>Nom <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               name="nom" 
                                               id="nom"
                                               class="form-control border-start-0 ps-0" 
                                               placeholder="Entrez le nom"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="prenom" class="form-label fw-semibold text-dark">
                                        <i class="fas fa-user me-2 text-primary"></i>Prénom <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-id-card text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               name="prenom" 
                                               id="prenom"
                                               class="form-control border-start-0 ps-0" 
                                               placeholder="Entrez le prénom"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-dark">
                                <i class="fas fa-envelope me-2 text-primary"></i>Adresse Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-at text-muted"></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       class="form-control border-start-0 ps-0" 
                                       placeholder="exemple@domaine.com"
                                       required>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>Cette adresse sera utilisée pour la connexion
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">
                                <i class="fas fa-lock me-2 text-primary"></i>Mot de passe <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key text-muted"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="form-control border-start-0 ps-0" 
                                       placeholder="Mot de passe sécurisé"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-shield-alt me-1"></i>Minimum 8 caractères recommandés
                            </div>
                        </div>

                        {{-- Future: Matières section --}}
                        <div class="alert alert-info border-0 bg-light-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-lightbulb text-info me-3"></i>
                                <div>
                                    <strong>À venir :</strong> La sélection des matières sera disponible dans une prochaine version.
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('admin.enseignants.index') }}" class="btn btn-light px-4">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-plus-circle me-2"></i>Ajouter le Formateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Styles */
.avatar-lg {
    height: 80px;
    width: 80px;
}

.avatar-sm {
    height: 40px;
    width: 40px;
}

.avatar-title {
    align-items: center;
    background-color: #f8f9fa;
    color: #6c757d;
    display: flex;
    font-weight: 600;
    height: 100%;
    justify-content: center;
    width: 100%;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
}

.input-group-text {
    transition: all 0.3s ease;
}

.form-control:focus + .input-group-text,
.form-control:focus ~ .input-group-text {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
}

.bg-light-info {
    background-color: rgba(13, 202, 240, 0.1) !important;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .card-body {
        padding: 1.5rem !important;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-lg {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
    
    // Form validation enhancement
    const form = document.getElementById('formateurForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('input[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Show error message
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        });
    }
});
</script>
@endsection