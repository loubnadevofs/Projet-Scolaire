@extends('layouts.enseignant')

@section('title', 'Gestion des Notes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Gestion des Notes</h3>
                    <a href="{{ route('enseignant.notations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter une Note
                    </a>
                </div>

                <div class="card-body">
                    <!-- Formulaire de recherche -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="{{ route('enseignant.notations.search') }}" method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" name="q" class="form-control" placeholder="Rechercher un étudiant..." value="{{ request('q') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="matiere_id" class="form-control">
                                        <option value="">Toutes les matières</option>
                                        @foreach($enseignant->matieres as $matiere)
                                            <option value="{{ $matiere->idMatiere }}" {{ request('matiere_id') == $matiere->idMatiere ? 'selected' : '' }}>
                                                {{ $matiere->nomMatiere }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="classe_id" class="form-control">
                                        <option value="">Toutes les classes</option>
                                        @php
                                            $classes = \App\Models\Classe::whereHas('etudiants.notations.matiere.enseignants', function($query) use ($enseignant) {
                                                $query->where('enseignants.idEnsei', $enseignant->idEnsei);
                                            })->get();
                                        @endphp
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->idClasse }}" {{ request('classe_id') == $classe->idClasse ? 'selected' : '' }}>
                                                {{ $classe->nomClasse }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search"></i> Rechercher
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Messages de succès -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Tableau des notations -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Étudiant</th>
                                    <th>Classe</th>
                                    <th>Matière</th>
                                    <th>Note</th>
                                    <th>Date d'évaluation</th>
                                    <th>Année scolaire</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notations as $notation)
                                    <tr>
                                        <td>{{ $notation->idN }}</td>
                                        <td>{{ $notation->etudiant->nom }} {{ $notation->etudiant->prenom }}</td>
                                        <td>{{ $notation->etudiant->classe->nomClasse ?? 'N/A' }}</td>
                                        <td>{{ $notation->matiere->nomMatiere }}</td>
                                        <td>
                                            <span class="badge {{ $notation->note >= 10 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $notation->note }}/20
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($notation->dateEv)->format('d/m/Y') }}</td>
                                        <td>{{ $notation->annee_scolaire ?? date('Y') . '-' . (date('Y') + 1) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('enseignant.notations.show', $notation->idN) }}" 
                                                   class="btn btn-info btn-sm" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('enseignant.notations.edit', $notation->idN) }}" 
                                                   class="btn btn-warning btn-sm" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('enseignant.notations.destroy', $notation->idN) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Aucune notation trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $notations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection