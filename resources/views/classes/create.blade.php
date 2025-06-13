<!-- resources/views/classes/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Liste des Classes')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Créer une Nouvelle Classe</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom de la classe</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="niveau" class="form-label">Niveau</label>
                    <input type="text" class="form-control @error('niveau') is-invalid @enderror" id="niveau" name="niveau" value="{{ old('niveau') }}" required>
                    @error('niveau')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
@endsection