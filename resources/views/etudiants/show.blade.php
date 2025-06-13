@extends('layouts.admin')

@section('title', 'Détails de l\'Étudiant')

@section('styles')
<style>
    .page-background {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .student-profile-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
        transition: transform 0.3s ease;
    }
    
    .student-profile-card:hover {
        transform: translateY(-5px);
    }
    
    .profile-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .profile-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
    }
    
    .profile-actions {
        display: flex;
        gap: 1rem;
        position: relative;
        z-index: 2;
    }
    
    .btn-profile-action {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        border: 2px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.1);
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .btn-profile-action:hover {
        background: rgba(255,255,255,0.2);
        border-color: rgba(255,255,255,0.5);
        transform: translateY(-2px);
        color: white;
    }
    
    .profile-content {
        padding: 2.5rem;
    }
    
    .student-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .info-card {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        padding: 2rem;
        border-radius: 20px;
        border-left: 5px solid #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.2);
    }
    
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
        color: white;
    }
    
    .info-icon.id { background: linear-gradient(45deg, #667eea, #764ba2); }
    .info-icon.name { background: linear-gradient(45deg, #f093fb, #f5576c); }
    .info-icon.birth { background: linear-gradient(45deg, #4facfe, #00f2fe); }
    .info-icon.class { background: linear-gradient(45deg, #fa709a, #fee140); }
    
    .info-content {
        flex-grow: 1;
    }
    
    .info-label {
        font-weight: 600;
        color: #4a5568;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.3rem;
    }
    
    .info-value {
        font-size: 1.1rem;
        color: #2d3748;
        font-weight: 500;
    }
    
    .section-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.5rem 2rem;
        color: white;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .section-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    
    .section-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin: 0;
    }
    
    .section-content {
        padding: 2rem;
    }
    
    .modern-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: none;
    }
    
    .modern-table thead th {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        color: #4a5568;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1.2rem;
        border: none;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }
    
    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        transform: scale(1.01);
    }
    
    .modern-table tbody td {
        padding: 1.2rem;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #e8f2ff;
    }
    
    .grade-badge {
        background: linear-gradient(45deg, #4facfe, #00f2fe);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-block;
    }
    
    .high-grade {
        background: linear-gradient(45deg, #11998e, #38ef7d);
    }
    
    .medium-grade {
        background: linear-gradient(45deg, #fa709a, #fee140);
    }
    
    .low-grade {
        background: linear-gradient(45deg, #ff6b6b, #ee5a52);
    }
    
    .absence-hours {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-block;
    }
    
    .total-absences {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        padding: 1rem 2rem;
        border-radius: 15px;
        text-align: center;
        margin-top: 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #718096;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
        display: block;
    }
    
    .empty-state-text {
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .profile-header {
            padding: 1.5rem;
        }
        
        .profile-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .profile-actions {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .student-info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .info-card, .section-content {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-background">
    <div class="container">
        <div class="student-profile-card">
            <div class="profile-header">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h1 class="profile-title">
                        <i class="fas fa-user-graduate me-3"></i>
                        Profil Étudiant
                    </h1>
                    <div class="profile-actions">
                        <a href="{{ route('admin.etudiants.edit', $etudiant->idEtu) }}" class="btn-profile-action">
                            <i class="fas fa-edit me-2"></i>
                            Modifier
                        </a>
                        <a href="{{ route('admin.etudiants.index') }}" class="btn-profile-action">
                            <i class="fas fa-arrow-left me-2"></i>
                            Retour
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="profile-content">
                <div class="student-info-grid">
                    <div class="info-card">
                        <div class="info-item">
                            <div class="info-icon id">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Identifiant</div>
                                <div class="info-value">{{ $etudiant->idEtu }}</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon name">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Nom Complet</div>
                                <div class="info-value">{{ $etudiant->nom }} {{ $etudiant->prenom }}</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon birth">
                                <i class="fas fa-birthday-cake"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Date de Naissance</div>
                                <div class="info-value">{{ $etudiant->dateNaissance }}</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon class">
                                <i class="fas fa-school"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Classe</div>
                                <div class="info-value">{{ $etudiant->classe->nom }} ({{ $etudiant->classe->niveau }})</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Notes -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="section-title">Notes et Évaluations</h3>
            </div>
            <div class="section-content">
                @if($etudiant->notations->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-book me-2"></i>Matière</th>
                                    <th><i class="fas fa-star me-2"></i>Note</th>
                                    <th><i class="fas fa-calendar-alt me-2"></i>Date d'Évaluation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etudiant->notations as $notation)
                                    <tr>
                                        <td>
                                            <strong>{{ $notation->matiere->nomM }}</strong>
                                        </td>
                                        <td>
                                            <span class="grade-badge {{ $notation->note >= 16 ? 'high-grade' : ($notation->note >= 10 ? 'medium-grade' : 'low-grade') }}">
                                                {{ $notation->note }}/20
                                            </span>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                            {{ $notation->dateEv }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <div class="empty-state-text">Aucune note enregistrée pour cet étudiant</div>
                        <small class="text-muted">Les évaluations apparaîtront ici une fois saisies</small>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section Absences -->
        <div class="section-card">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <h3 class="section-title">Absences et Retards</h3>
            </div>
            <div class="section-content">
                @if($etudiant->absences->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                    <th><i class="fas fa-calendar-times me-2"></i>Date d'Absence</th>
                                    <th><i class="fas fa-clock me-2"></i>Nombre d'Heures</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etudiant->absences as $absence)
                                    <tr>
                                        <td>
                                            <strong>#{{ $absence->idA }}</strong>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar me-2 text-muted"></i>
                                            {{ $absence->dateAbsen }}
                                        </td>
                                        <td>
                                            <span class="absence-hours">
                                                {{ $absence->nbrHeuAbsence }} h
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="total-absences">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Total des heures d'absence: {{ $etudiant->absences->sum('nbrHeuAbsence') }} h</strong>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-user-check"></i>
                        <div class="empty-state-text">Aucune absence enregistrée pour cet étudiant</div>
                        <small class="text-muted">Excellente assiduité !</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection