@extends('layouts.admin')
@section('title', 'Liste des Absences')

@section('content')
<style>
    .absences-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .main-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 2rem;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
        font-weight: 300;
    }

    .modern-table {
        margin: 0;
        border: none;
        background: transparent;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
    }

    .modern-table thead th {
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 1.5rem 1rem;
        border: none;
        font-size: 0.9rem;
        position: relative;
    }

    .modern-table thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 3px;
        background: #00f2fe;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .modern-table thead th:hover::after {
        width: 80%;
    }

    .modern-table tbody tr {
        background: white;
        transition: all 0.4s ease;
        border: none;
        position: relative;
    }

    .modern-table tbody tr:nth-child(even) {
        background: rgba(102, 126, 234, 0.02);
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1), rgba(0, 242, 254, 0.1));
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .modern-table tbody tr::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .modern-table tbody tr:hover::before {
        transform: scaleY(1);
    }

    .modern-table td {
        padding: 1.2rem 1rem;
        border: none;
        font-weight: 500;
        color: #2c3e50;
        vertical-align: middle;
        position: relative;
    }

    .student-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.9rem;
        text-transform: uppercase;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .student-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .absence-badge {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 8px rgba(238, 90, 82, 0.3);
        display: inline-block;
    }

    .date-badge {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 8px rgba(79, 172, 254, 0.3);
        display: inline-block;
    }

    .hours-display {
        font-size: 1.1rem;
        font-weight: 700;
        color: #e74c3c;
        background: rgba(231, 76, 60, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 15px;
        display: inline-block;
    }

    .text-warning-modern {
        color: #f39c12;
        font-weight: 600;
        font-style: italic;
        background: rgba(243, 156, 18, 0.1);
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        display: inline-block;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #7f8c8d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .stats-row {
        padding: 1.5rem 2rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(79, 172, 254, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(79, 172, 254, 0); }
        100% { box-shadow: 0 0 0 0 rgba(79, 172, 254, 0); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .absences-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .modern-table {
            font-size: 0.9rem;
        }
        
        .modern-table td, .modern-table th {
            padding: 0.8rem 0.5rem;
        }
        
        .student-avatar {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }
    }
</style>

<div class="absences-container">
    <div class="container">
        <div class="main-card fade-in">
            <!-- Header -->
            <div class="card-header">
                <h1 class="page-title">
                    <i class="fas fa-calendar-times me-3"></i>
                    Gestion des Absences
                </h1>
                <p class="page-subtitle">Suivi et gestion des absences étudiantes</p>
            </div>

            <!-- Table Content -->
            <div class="card-body p-0">
                @if($absences && count($absences) > 0)
                    <div class="table-responsive">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                    <th><i class="fas fa-user-graduate me-2"></i>Étudiant</th>
                                    <th><i class="fas fa-calendar-alt me-2"></i>Date d'absence</th>
                                    <th><i class="fas fa-clock me-2"></i>Heures d'absence</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absences as $absence)
                                    <tr class="fade-in">
                                        <td>
                                            <span class="badge bg-primary pulse">{{ $absence->idA }}</span>
                                        </td>
                                        <td>
                                            <div class="student-info">
                                                @if($absence->etudiant)
                                                    <div class="student-avatar">
                                                        {{ substr($absence->etudiant->prenom, 0, 1) }}{{ substr($absence->etudiant->nom, 0, 1) }}
                                                    </div>
                                                    <div class="student-name">
                                                        {{ $absence->etudiant->nom }} {{ $absence->etudiant->prenom }}
                                                    </div>
                                                @else
                                                    <span class="text-warning-modern">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Étudiant non trouvé
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="date-badge">
                                                <i class="fas fa-calendar me-2"></i>
                                                {{ \Carbon\Carbon::parse($absence->dateAbsen)->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="hours-display">
                                                <i class="fas fa-hourglass-half me-2"></i>
                                                {{ $absence->nbrHeuAbsence }} h
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Stats Row -->
                    <div class="stats-row">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h5 class="text-primary">{{ count($absences) }}</h5>
                                <small class="text-muted">Total Absences</small>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-warning">{{ $absences->sum('nbrHeuAbsence') }}</h5>
                                <small class="text-muted">Heures Totales</small>
                            </div>
                            <div class="col-md-4">
                                <h5 class="text-info">{{ $absences->unique('etudiant_id')->count() }}</h5>
                                <small class="text-muted">Étudiants Concernés</small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <h4>Aucune absence enregistrée</h4>
                        <p class="text-muted">Il n'y a actuellement aucune absence dans le système.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection