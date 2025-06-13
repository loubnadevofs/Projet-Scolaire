<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Système de Gestion</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg,rgb(75, 106, 245) 0%,rgb(143, 82, 205) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            border-color: #667eea;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .alert {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card login-card shadow-lg">
                    <div class="card-header login-header text-center py-4">
                        <h4 class="mb-0">
                            <i class="fas fa-user-shield me-2"></i>
                            Connexion
                        </h4>
                        <p class="mb-0 mt-2 opacity-75">
                            <small>Administrateur ou Enseignant</small>
                        </p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Affichage des erreurs -->
                        @if($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <div>
                                        @foreach($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Message de succès si déconnexion -->
                        @if(session('status'))
                            <div class="alert alert-success border-0 shadow-sm mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div>{{ session('status') }}</div>
                                </div>
                            </div>
                        @endif

                        <!-- Formulaire de connexion unifié -->
                        <form method="POST" action="{{ route('enseignant.login') }}" id="loginForm">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope me-1"></i>Adresse Email
                                </label>
                                <input type="email" 
                                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="votre@email.com"
                                       required 
                                       autocomplete="email" 
                                       autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold">
                                    <i class="fas fa-lock me-1"></i>Mot de passe
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="••••••••"
                                           required 
                                           autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember" 
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg btn-login" id="loginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </button>
                            </div>
                        </form>

                        <!-- Informations sur les types d'utilisateurs -->
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Connectez-vous avec vos identifiants d'administrateur ou d'enseignant
                            </small>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <a href="{{ route('accueil') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Aide pour les utilisateurs -->
                <div class="card mt-3 border-0 bg-transparent">
                    <div class="card-body text-center text-white">
                        <div class="row">
                            <div class="col-6">
                                <div class="p-3 rounded bg-white bg-opacity-10">
                                    <i class="fas fa-user-cog fa-2x mb-2"></i>
                                    <h6>Administrateur</h6>
                                    <small>Gestion complète du système</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded bg-white bg-opacity-10">
                                    <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                                    <h6>Enseignant</h6>
                                    <small>Gestion des cours et notes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section de test des comptes -->
                <div class="card mt-3 border-0 bg-white bg-opacity-10">
                    <div class="card-body text-white">
                        <h6 class="text-center mb-3">
                            <i class="fas fa-key me-2"></i>Comptes de test
                        </h6>
                        <div class="row text-center">
                            <div class="col-12 mb-2">
                                <small><strong>Admin:</strong> admin@school.com / admin123</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Affichage/masquage du mot de passe
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Animation du bouton lors de la soumission
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connexion...';
            btn.disabled = true;
        });

        // Validation côté client
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs');
                return false;
            }
            
            // Validation email basique
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Adresse email invalide');
                return false;
            }
        });
    </script>
</body>
</html>