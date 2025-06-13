@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Détail de la note</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">Étudiant</th>
                                    <td>
                                        @if ($notation->etudiant)
                                            {{ $notation->etudiant->nom }} {{ $notation->etudiant->prenom }}
                                        @else
                                            Étudiant inconnu
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Matière</th>
                                    <td>
                                        @if ($notation->matiere)
                                            {{ $notation->matiere->nomM }}
                                        @else
                                            Matière inconnue
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Note</th>
                                    <td><strong>{{ $notation->note }}</strong>/20</td>
                                </tr>
                                <tr>
                                    <th>Date d'évaluation</th>
                                    <td>{{ \Carbon\Carbon::parse($notation->dateEv)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Année scolaire</th>
                                    <td>{{ $notation->annee_scolaire }}</td>
                                </tr>
                                <tr>
                                    <th>Date de création</th>
                                    <td>{{ $notation->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Dernière modification</th>
                                    <td>{{ $notation->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                        <a href="{{ route('admin.notations.index') }}" class="btn btn-secondary me-md-2">Retour à la liste</a>
                        <a href="{{ route('admin.notations.edit', $notation->id) }}" class="btn btn-warning me-md-2">Modifier</a>
                        <form action="{{ route('admin.notations.destroy', $notation->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cette note ?');">
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