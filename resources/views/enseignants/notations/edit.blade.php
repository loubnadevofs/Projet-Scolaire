@extends('layouts.enseignant')

@section('title', 'Modifier la Note')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier la Note</h3>
                    <div class="card-tools">
                        <a href="{{ route('enseignant.notations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
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

                    <form action="{{ route('enseignant.notations.update', $notation->idN) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="idEtu" class="form-label">Étudiant *</label>
                                    <select name="idEtu" id="idEtu" class="form-control" required>
                                        <option value="">Sélectionner un étudiant</option>
                                        @foreach($etudiants as $etudiant)
                                            <option value="{{ $etudiant->idEtu }}" 
                                                {{ (old('idEtu', $notation->idEtu) == $etudiant->idEtu) ? 'selected' : '' }}>
                                                {{ $etudiant->nom }} {{ $etudiant->prenom }} - {{ $etudiant->classe->nomClasse ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="idMatiere" class="form-label">Matière *</label>
                                    <select name="idMatiere" id="idMatiere" class="form-control" required>
                                        <option value="">Sélectionner une matière</option>
                                        @foreach($matieres as $matiere)
                                            <option value="{{ $matiere->idMatiere }}" 
                                                {{ (old('idMatiere', $notation->idMatiere) == $matiere->idMatiere) ? 'selected' : '' }}>
                                                {{ $matiere->nomMatiere }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Note */20 *</label>
                                    <input type="number" name="note" id="note" class="form-control" 
                                           min="0" max="20" step="0.25" 
                                           value="{{ old('note', $notation->note) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dateEv" class="form-label">Date d'évaluation *</label>
                                    <input type="date" name="dateEv" id="dateEv" class="form-control" 
                                           value="{{ old('dateEv', $notation->dateEv) }}" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="annee_scolaire" class="form-label">Année scolaire *</label>
                                    <input type="text" name="annee_scolaire" id="annee_scolaire" class="form-control" 
                                           value="{{ old('annee_scolaire', $notation->annee_scolaire ?? date('Y') . '-' . (date('Y') + 1)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                                    <textarea name="commentaire" id="commentaire" class="form-control" rows="3" 
                                              placeholder="Commentaire sur la note...">{{ old('commentaire', $notation->commentaire ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Mettre à jour
                                </button>
                                <a href="{{ route('enseignant.notations.show', $notation->idN) }}" class="btn btn-info">
                                    <i class="fas fa-eye">