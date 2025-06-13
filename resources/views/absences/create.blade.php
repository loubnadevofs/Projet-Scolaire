@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Ajouter une absence</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.absences.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="idEtu" class="form-label">Étudiant</label>
                                <select class="form-select @error('idEtu') is-invalid @enderror" id="idEtu" name="idEtu" required>
                                    <option value="">Sélectionner un étudiant</option>
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
                                <label for="dateAbsen" class="form-label">Date d'absence</label>
                                <input type="date" class="form-control @error('dateAbsen') is-invalid @enderror" id="dateAbsen" name="dateAbsen" value="{{ old('dateAbsen') }}" required>
                                @error('dateAbsen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nbrHeuAbsence" class="form-label">Nombre d'heures d'absence</label>
                                <input type="number" class="form-control @error('nbrHeuAbsence') is-invalid @enderror" id="nbrHeuAbsence" name="nbrHeuAbsence" value="{{ old('nbrHeuAbsence') }}" min="0" step="1" required>
                                @error('nbrHeuAbsence')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection