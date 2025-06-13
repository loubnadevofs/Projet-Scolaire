@extends('layouts.admin')

@section('title', 'Liste des Étudiants')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    .students-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .students-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        padding: 1.5rem 2rem;
        border: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
    
    .btn-add-student {
        background: linear-gradient(45deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        color: white;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
    }
    
    .btn-add-student:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
        color: white;
    }
    
    .table-container {
        padding: 2rem;
        background: #f8f9ff;
    }
    
    .table-modern {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: none;
    }
    
    .table-modern thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        border: none;
        position: relative;
    }
    
    .table-modern thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }
    
    .table-modern tbody tr {
        transition: all 0.3s ease;
        border: none;
    }
    
    .table-modern tbody tr:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #e8f2ff;
    }
    
    .student-id {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
    }
    
    .student-name {
        font-weight: 600;
        color: #2d3748;
        font-size: 1rem;
    }
    
    .student-class {
        background: linear-gradient(45deg, #f093fb, #f5576c);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        border: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .btn-view {
        background: linear-gradient(45deg, #4facfe, #00f2fe);
        color: white;
    }
    
    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        color: white;
    }
    
    .btn-edit {
        background: linear-gradient(45deg, #fa709a, #fee140);
        color: white;
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(250, 112, 154, 0.4);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(45deg, #ff6b6b, #ee5a52);
        color: white;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
    }
    
    .no-students {
        text-align: center;
        padding: 3rem;
        color: #718096;
        font-size: 1.1rem;
    }
    
    .no-students i {
        font-size: 3rem;
        color: #cbd5e0;
        margin-bottom: 1rem;
        display: block;
    }
    
    .delete-form {
        display: inline;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .card-header-custom {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="page-title text-center">
            <i class="fas fa-graduation-cap me-3"></i>
            Gestion des Étudiants
        </h1>
    </div>
</div>

<div class="container">
    <div class="students-card">
        <div class="card-header-custom">
            <h2 class="card-title">
                <i class="fas fa-users me-2"></i>
                Liste des Étudiants
            </h2>
            <a href="{{ route('admin.etudiants.create') }}" class="btn-add-student">
                <i class="fas fa-plus me-2"></i>
                Ajouter un étudiant
            </a>
        </div>
        
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2"></i>ID</th>
                            <th><i class="fas fa-user me-2"></i>Nom</th>
                            <th><i class="fas fa-user-tag me-2"></i>Prénom</th>
                            <th><i class="fas fa-school me-2"></i>Classe</th>
                            <th><i class="fas fa-calendar me-2"></i>Date de naissance</th>
                            <th><i class="fas fa-cogs me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($etudiants as $etudiant)
                            <tr>
                                <td>
                                    <span class="student-id">{{ $etudiant->idEtu }}</span>
                                </td>
                                <td>
                                    <span class="student-name">{{ $etudiant->nom }}</span>
                                </td>
                                <td>
                                    <span class="student-name">{{ $etudiant->prenom }}</span>
                                </td>
                                <td>
                                    <span class="student-class">
                                        {{ $etudiant->classe->nom }} ({{ $etudiant->classe->niveau }})
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-birthday-cake me-2 text-muted"></i>
                                    {{ $etudiant->dateNaissance }}
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.etudiants.show', $etudiant->idEtu) }}" 
                                           class="btn-action btn-view">
                                            <i class="fas fa-eye"></i>
                                            Voir
                                        </a>
                                        <a href="{{ route('admin.etudiants.edit', $etudiant->idEtu) }}" 
                                           class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i>
                                            Modifier
                                        </a>
                                        <form action="{{ route('admin.etudiants.destroy', $etudiant->idEtu) }}" 
                                              method="POST" 
                                              class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-action btn-delete" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant?')">
                                                <i class="fas fa-trash"></i>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="no-students">
                                    <i class="fas fa-user-graduate"></i>
                                    <div>Aucun étudiant trouvé</div>
                                    <small class="text-muted">Commencez par ajouter votre premier étudiant</small>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection