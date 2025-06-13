@extends('layouts.admin')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Modifier une absence</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.absences.update', $absence->idA) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="idEtu" class="form-label">Étudiant</label>
                                <select class="form-select @error('idEtu') is-invalid @enderror" id="idEtu" name="idEtu" required>
                                    <option value="">Sélectionner un étudiant</option>
                                    @foreach($etudiants as $etudiant)
                                        <option value="{{ $etudiant->idEtu }}" {{ (old('idEtu', $absence->idEtu) == $etudiant->idEtu) ? 'selected' : '' }}>
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
                                <input type="date" class="form-control @error('dateAbsen') is-invalid @enderror" id="dateAbsen" name="dateAbsen" value="{{ old('dateAbsen', $absence->dateAbsen) }}" required>
                                @error('dateAbsen')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nbrHeuAbsence" class="form-label">Nombre d'heures d'absence</label>
                                <input type="number" class="form-control @error('nbrHeuAbsence') is-invalid @enderror" id="nbrHeuAbsence" name="nbrHeuAbsence" value="{{ old('nbrHeuAbsence', $absence->nbrHeuAbsence) }}" min="0" step="1" required>
                                @error('nbrHeuAbsence')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">Annuler</a>
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection