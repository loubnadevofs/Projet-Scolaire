<!-- resources/views/absences/show.blade.php -->
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Détails de l'absence</h3>
                        <a href="{{ route('admin.absences.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <h5>Information de l'étudiant</h5>
                            <p><strong>Nom complet:</strong> {{ $absence->etudiant->nom }} {{ $absence->etudiant->prenom }}</p>
                            <p><strong>ID Étudiant:</strong> {{ $absence->etudiant->idEtu }}</p>
                        </div>

                        <div class="mb-3">
                            <h5>Information de l'absence</h5>
                            <p><strong>ID Absence:</strong> {{ $absence->idA }}</p>
                            <p><strong>Date d'absence:</strong> {{ \Carbon\Carbon::parse($absence->dateAbsen)->format('d/m/Y') }}</p>
                            <p><strong>Nombre d'heures d'absence:</strong> {{ $absence->nbrHeuAbsence }}</p>
                        </div>

                        <div class="d-flex mt-4">
                            <a href="{{ route('admin.absences.edit', $absence->idA) }}" class="btn btn-primary me-2">Modifier</a>
                            <form action="{{ route('admin.absences.destroy', $absence->idA) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette absence?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection