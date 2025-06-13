@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Détails de la Matière : {{ $matiere->nomM }}</h1>

        <div class="mb-3">
            <strong>Nom : </strong>{{ $matiere->nomM }}
        </div>
        <div class="mb-3">
            <strong>Coefficient : </strong>{{ $matiere->coefficient }}
        </div>

        <h3>Enseignants :</h3>
        @if($matiere->enseignants->isEmpty())
            <p>Aucun enseignant n'est associé à cette matière.</p>
        @else
            <ul>
                @foreach ($matiere->enseignants as $enseignant)
                    <li>{{ $enseignant->nom}}</li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </div>
@endsection
