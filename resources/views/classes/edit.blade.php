<!-- resources/views/classes/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Modification d\'une Classe')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Modifier la Classe</h2>
        </div>
        <div class="card-body">
        <form action="{{ route('admin.classes.update', $classe->idClasse) }}" method="POST">

                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la classe</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $classe->nom) }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="niveau" class="form-label">Niveau</label>
                    <input type="text" class="form-control @error('niveau') is-invalid @enderror" id="niveau" name="niveau" value="{{ old('niveau', $classe->niveau) }}" required>
                    @error('niveau')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection
