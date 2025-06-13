@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Ajouter une note</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.notations.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="idEtu" class="form-label">Étudiant</label>
                            <select name="idEtu" id="idEtu" class="form-select @error('idEtu') is-invalid @enderror" required>
                                <option value="">-- Sélectionner un étudiant --</option>
                                @foreach($etudiants as $etudiant)
                                    <option value="{{ $etudiant->idEtu }}" {{ old('idEtu') == $etudiant->idEtu ? 'selected' : '' }}>
                                        {{ $etudiant->nom }} {{ $etudiant->prenom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idEtu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="idMatiere" class="form-label">Matière</label>
                            <select name="idMatiere" id="idMatiere" class="form-select @error('idMatiere') is-invalid @enderror" required>
                                <option value="">-- Sélectionner une matière --</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->idMatiere }}" {{ old('idMatiere') == $matiere->idMatiere ? 'selected' : '' }}>
                                        {{ $matiere->nomM }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idMatiere')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <input type="number" step="0.01" name="note" id="note" class="form-control @error('note') is-invalid @enderror" 
                                min="0" max="20" value="{{ old('note') }}" required>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="dateEv" class="form-label">Date d'évaluation</label>
                            <input type="date" name="dateEv" id="dateEv" class="form-control @error('dateEv') is-invalid @enderror" 
                                value="{{ old('dateEv') ?? date('Y-m-d') }}" required>
                            @error('dateEv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="annee_scolaire" class="form-label">Année scolaire</label>
                            <input type="text" name="annee_scolaire" id="annee_scolaire" class="form-control @error('annee_scolaire') is-invalid @enderror"  required>
                            @error('annee_scolaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.notations.index') }}" class="btn btn-secondary me-md-2">Annuler</a>
                            <button type="submit" class="btn btn-warning">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection