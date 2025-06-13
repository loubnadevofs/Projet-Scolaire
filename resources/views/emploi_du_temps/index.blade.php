@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Emploi du Temps Hebdomadaire</h6>
            <div>
                <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimer
                </button>
                <button class="btn btn-sm btn-outline-success" id="exportBtn">
                    <i class="fas fa-file-excel"></i> Exporter
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="emploiDuTemps" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="bg-light text-center">Horaire</th>
                            @foreach($jours as $jour)
                                <th class="bg-light text-center">{{ $jour }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($heures as $heure)
                            <tr>
                                <td class="font-weight-bold text-center" style="width: 120px;">
                                    {{ $heure }}
                                </td>
                                @foreach($jours as $jour)
                                    @if($emploiDuTemps[$jour][$heure])
                                        @php $cours = $emploiDuTemps[$jour][$heure]; @endphp
                                        <td class="bg-{{ $cours['couleur'] }}-light">
                                            <div class="cours-box">
                                                <div class="cours-titre font-weight-bold">{{ $cours['matiere'] }}</div>
                                                <div class="cours-prof small">{{ $cours['prof'] }}</div>
                                                <div class="cours-salle badge badge-light">Salle {{ $cours['salle'] }}</div>
                                            </div>
                                        </td>
                                    @else
                                        <td class="bg-light-gray">
                                            <div class="text-center text-muted small">
                                                <i class="fas fa-coffee"></i> Libre
                                            </div>
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-light { background-color: rgba(78, 115, 223, 0.15); }
    .bg-success-light { background-color: rgba(28, 200, 138, 0.15); }
    .bg-info-light { background-color: rgba(54, 185, 204, 0.15); }
    .bg-warning-light { background-color: rgba(246, 194, 62, 0.15); }
    .bg-danger-light { background-color: rgba(231, 74, 59, 0.15); }
    .bg-light-gray { background-color: #f8f9fc; }
    
    .cours-box {
        padding: 8px;
        min-height: 80px;
    }
    
    .cours-titre {
        margin-bottom: 5px;
    }
    
    .cours-prof {
        margin-bottom: 5px;
        color: #555;
    }
    
    .cours-salle {
        font-size: 0.8rem;
    }
    
    @media print {
        .btn { display: none; }
        .card-header { border-bottom: 1px solid #e3e6f0; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Code pour l'exportation (peut être développé davantage)
        document.getElementById('exportBtn').addEventListener('click', function() {
            alert('Fonctionnalité d\'exportation à implémenter');
        });
    });
</script>
@endsection