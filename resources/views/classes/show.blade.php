<!-- resources/views/classes/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Détails de la Classe')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Détails de la Classe</h2>
            <div>
                <a href="{{ route('admin.classes.edit', $classe->idClasse) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>ID:</strong> {{ $classe->idClasse }}
            </div>
            <div class="mb-3">
                <strong>Nom:</strong> {{ $classe->nom }}
            </div>
            <div class="mb-3">
                <strong>Niveau:</strong> {{ $classe->niveau }}
            </div>
            
            <h3 class="mt-4 mb-3">Étudiants dans cette classe</h3>
            @if($classe->etudiants->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de naissance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classe->etudiants as $etudiant)
                            <tr>
                                <td>{{ $etudiant->idEtu }}</td>
                                <td>{{ $etudiant->nom }}</td>
                                <td>{{ $etudiant->prenom }}</td>
                                <td>{{ $etudiant->dateNaissance }}</td>
                                <td>
                                    <a href="{{ route('admin.etudiants.show', $etudiant->idEtu) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Aucun étudiant inscrit dans cette classe.</p>
            @endif
        </div>
    </div>
@endsection