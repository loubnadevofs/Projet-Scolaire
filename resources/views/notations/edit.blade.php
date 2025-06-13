@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Modifier la note</h1>

        <form method="POST" action="{{ route('admin.notations.update', ['notation' => $notation->id]) }}">
            @csrf
            @method('PUT')

            <!-- Étudiant -->
            <div class="mb-3">
                <label for="idEtu" class="form-label">Étudiant:</label>
                <select id="idEtu" name="idEtu" class="form-select">
                    @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->idEtu }}" {{ $notation->idEtu == $etudiant->idEtu ? 'selected' : '' }}>
                            {{ $etudiant->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Matière -->
            <div class="mb-3">
                <label for="idMatiere" class="form-label">Matière:</label>
                <select id="idMatiere" name="idMatiere" class="form-select">
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->idMatiere }}" {{ $notation->idMatiere == $matiere->idMatiere ? 'selected' : '' }}>
                            {{ $matiere->nomM }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Note -->
            <div class="mb-3">
                <label for="note" class="form-label">Note:</label>
                <input type="number" id="note" name="note" class="form-control" value="{{ $notation->note }}" min="0" max="20">
            </div>

            <!-- Date d'évaluation -->
            <div class="mb-3">
                <label for="dateEv" class="form-label">Date d’évaluation:</label>
                <input type="date" id="dateEv" name="dateEv" class="form-control" value="{{ $notation->dateEv }}">
            </div>

            <!-- Année scolaire -->
            <div class="mb-3">
                <label for="annee_scolaire" class="form-label">Année scolaire:</label>
                <input type="text" id="annee_scolaire" name="annee_scolaire" class="form-control" value="{{ $notation->annee_scolaire }}">
            </div>

            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
@endsection
