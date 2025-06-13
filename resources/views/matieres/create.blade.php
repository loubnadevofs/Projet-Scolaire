@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Ajouter une Matière</h1>

        <form action="{{ route('admin.matieres.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nomM">Nom de la Matière</label>
                <input type="text" name="nomM" id="nomM" class="form-control" value="{{ old('nomM') }}" required>
                @error('nomM')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="coefficient">Coefficient</label>
                <input type="number" name="coefficient" id="coefficient" class="form-control" value="{{ old('coefficient') }}" required>
                @error('coefficient')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Créer</button>
        </form>
    </div>
@endsection
