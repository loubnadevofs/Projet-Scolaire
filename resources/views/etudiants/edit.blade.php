@extends('layouts.admin')

@section('title', 'Modification d\'un Étudiant')

@section('styles')
<style>
    .edit-page-background {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .edit-form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .edit-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.1);
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .edit-card:hover {
        transform: translateY(-10px);
    }
    
    .edit-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        padding: 2.5rem;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .edit-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    .edit-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
    }
    
    .edit-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .edit-form {
        padding: 3rem;
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    }
    
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }
    
    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.8rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }
    
    .label-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: white;
    }
    
    .label-icon.name { background: linear-gradient(45deg, #667eea, #764ba2); }
    .label-icon.class { background: linear-gradient(45deg, #f093fb, #f5576c); }
    .label-icon.date { background: linear-gradient(45deg, #4facfe, #00f2fe); }
    
    .form-control, .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 5px 20px rgba(102, 126, 234, 0.2);
        outline: none;
        transform: translateY(-2px);
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #e53e3e;
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1);
    }
    
    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
        border-color: #e53e3e;
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.1), 0 5px 20px rgba(229, 62, 62, 0.2);
    }
    
    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: #e53e3e;
        margin-top: 0.5rem;
        padding: 0.5rem 0.75rem;
        background: rgba(229, 62, 62, 0.1);
        border-radius: 8px;
        border-left: 3px solid #e53e3e;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 2px solid #e2e8f0;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 25px;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-submit:hover::before {
        left: 100%;
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-cancel {
        background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
        border: none;
        padding: 1rem 2rem;
        border-radius: 25px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(113, 128, 150, 0.3);
    }
    
    .btn-cancel:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(113, 128, 150, 0.4);
        color: white;
    }
    
    .input-group {
        position: relative;
    }
    
    .input-group .form-control {
        padding-left: 3rem;
    }
    
    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        z-index: 5;
        transition: color 0.3s ease;
    }
    
    .form-control:focus + .input-icon {
        color: #667eea;
    }
    
    .form-floating-effect {
        position: relative;
        overflow: hidden;
    }
    
    .form-floating-effect::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    
    .form-floating-effect:focus-within::after {
        width: 100%;
    }
    
    .success-message {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        border: none;
        box-shadow: 0 5px 20px rgba(56, 161, 105, 0.3);
    }
    
    @media (max-width: 768px) {
        .edit-page-background {
            padding: 1rem 0;
        }
        
        .edit-form {
            padding: 2rem 1.5rem;
        }
        
        .edit-header {
            padding: 2rem 1.5rem;
        }
        
        .edit-title {
            font-size: 1.8rem;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn-submit, .btn-cancel {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="edit-page-background">
    <div class="container">
        <div class="edit-form-container">
            <div class="edit-card">
                <div class="edit-header">
                    <h1 class="edit-title">
                        <i class="fas fa-user-edit me-3"></i>
                        Modifier l'Étudiant
                    </h1>
                    <p class="edit-subtitle">
                        Mettez à jour les informations de l'étudiant
                    </p>
                </div>
                
                <div class="edit-form">
                    <form action="{{ route('admin.etudiants.update', $etudiant->idEtu) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="nom" class="form-label">
                                <span class="label-icon name">
                                    <i class="fas fa-user"></i>
                                </span>
                                Nom de famille
                            </label>
                            <div class="form-floating-effect">
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom', $etudiant->nom) }}" 
                                       required
                                       placeholder="Saisissez le nom de famille">
                                @error('nom')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="prenom" class="form-label">
                                <span class="label-icon name">
                                    <i class="fas fa-user-tag"></i>
                                </span>
                                Prénom
                            </label>
                            <div class="form-floating-effect">
                                <input type="text" 
                                       class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" 
                                       name="prenom" 
                                       value="{{ old('prenom', $etudiant->prenom) }}" 
                                       required
                                       placeholder="Saisissez le prénom">
                                @error('prenom')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="idClasse" class="form-label">
                                <span class="label-icon class">
                                    <i class="fas fa-school"></i>
                                </span>
                                Classe
                            </label>
                            <div class="form-floating-effect">
                                <select class="form-select @error('idClasse') is-invalid @enderror" 
                                        id="idClasse" 
                                        name="idClasse" 
                                        required>
                                    <option value="">Sélectionner une classe</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->idClasse }}" 
                                                {{ (old('idClasse', $etudiant->idClasse) == $classe->idClasse) ? 'selected' : '' }}>
                                            {{ $classe->nom }} ({{ $classe->niveau }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('idClasse')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="dateNaissance" class="form-label">
                                <span class="label-icon date">
                                    <i class="fas fa-birthday-cake"></i>
                                </span>
                                Date de naissance
                            </label>
                            <div class="form-floating-effect">
                                <input type="date" 
                                       class="form-control @error('dateNaissance') is-invalid @enderror" 
                                       id="dateNaissance" 
                                       name="dateNaissance" 
                                       value="{{ old('dateNaissance', $etudiant->dateNaissance) }}" 
                                       required>
                                @error('dateNaissance')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('admin.etudiants.index') }}" class="btn-cancel">
                                <i class="fas fa-times me-2"></i>
                                Annuler
                            </a>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save me-2"></i>
                                Mettre à jour
                                <span class="position-relative"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection