@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Modifier la Matière</h1>

        <form action="{{ route('admin.matieres.update', $matiere) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nomM">Nom de la Matière</label>
                <input type="text" name="nomM" id="nomM" class="form-control" value="{{ old('nomM', $matiere->nomM) }}" required>
                @error('nomM')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="coefficient">Coefficient</label>
                <input type="number" name="coefficient" id="coefficient" class="form-control" value="{{ old('coefficient', $matiere->coefficient) }}" required>
                @error('coefficient')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
        </form>
    </div>
@endsection
