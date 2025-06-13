@extends('layouts.admin')

@section('title', __('Tableau de bord'))

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1 class="h3 mb-3">{{ __('Tableau de bord') }}</h1>
    </div>
</div>

<!-- Stats Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="card card-stats bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-white">{{ __('Étudiants') }}</h5>
                        <h2 class="mb-0">{{ $totalEtudiants ?? 0 }}</h2>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
                <p class="mt-3 mb-0">
                    <a href="{{ route('admin.etudiants.index') }}" class="text-white">{{ __('Voir détails') }} <i class="fas fa-arrow-right"></i></a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-white">{{ __('Enseignants') }}</h5>
                        <h2 class="mb-0">{{ $totalEnseignants ?? 0 }}</h2>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
                <p class="mt-3 mb-0">
                    <a href="{{ route('admin.enseignants.index') }}" class="text-white">{{ __('Voir détails') }} <i class="fas fa-arrow-right"></i></a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-white">{{ __('Matières') }}</h5>
                        <h2 class="mb-0">{{ $totalMatieres ?? 0 }}</h2>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <p class="mt-3 mb-0">
                    <a href="{{ route('admin.matieres.index') }}" class="text-white">{{ __('Voir détails') }} <i class="fas fa-arrow-right"></i></a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stats bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title text-white">{{ __('Absences') }}</h5>
                        <h2 class="mb-0">{{ $totalAbsences ?? 0 }}</h2>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                </div>
                <p class="mt-3 mb-0">
                    <a href="{{ route('admin.absences.index') }}" class="text-white">{{ __('Voir détails') }} <i class="fas fa-arrow-right"></i></a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Étudiants récents') }}</h5>
                <a href="{{ route('admin.etudiants.index') }}" class="btn btn-sm btn-primary">{{ __('Voir tous') }}</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Nom') }}</th>
                                <th>{{ __('Prénom') }}</th>
                                <th>{{ __('Classe') }}</th>
                                <th>{{ __('Date de naissance') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEtudiants ?? [] as $etudiant)
                            <tr>
                                <td>{{ $etudiant->nom }}</td>
                                <td>{{ $etudiant->prenom }}</td>
                                <td>{{ $etudiant->classe ? $etudiant->classe->nom : 'Pas de classe' }}</td>
                                <td>{{ $etudiant->dateNaissance }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">{{ __('Aucun étudiant trouvé') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('Résultats récents') }}</h5>
                <a href="{{ route('admin.notations.index') }}" class="btn btn-sm btn-primary">{{ __('Voir tous') }}</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Étudiant') }}</th>
                                <th>{{ __('Matière') }}</th>
                                <th>{{ __('Note') }}</th>
                                <th>{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentNotations ?? [] as $notation)
                            <tr>
                            <td>
    @if($notation->etudiant)
        {{ $notation->etudiant->nom }} {{ $notation->etudiant->prenom }}
    @else
        <span class="text-danger">Étudiant supprimé</span>
    @endif
</td>

                                <td>{{ $notation->matiere->nomM }}</td>
                                <td>{{ $notation->note }}/20</td>
                                <td>{{ $notation->dateEv }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">{{ __('Aucun résultat trouvé') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Résultats par matière') }}</h5>
            </div>
            <div class="card-body">
                <canvas id="resultsBySubject" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Absences par mois') }}</h5>
            </div>
            <div class="card-body">
                <canvas id="absencesByMonth" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    // Résultats par matière
    const resultsBySubjectCtx = document.getElementById('resultsBySubject').getContext('2d');
    const resultsBySubjectChart = new Chart(resultsBySubjectCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartMatieres ?? ['Mathématiques', 'Physique', 'Informatique', 'Langues', 'Histoire']) !!},
            datasets: [{
                label: '{{ __("Moyenne") }}',
                data: {!! json_encode($chartNotes ?? [14.5, 12.8, 16.2, 13.5, 11.9]) !!},
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Absences par mois
    const absencesByMonthCtx = document.getElementById('absencesByMonth').getContext('2d');
    const absencesByMonthChart = new Chart(absencesByMonthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartMois ?? ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc']) !!},
            datasets: [{
                label: '{{ __("Nombre d'absences") }}',
                data: {!! json_encode($chartAbsences ?? [12, 19, 8, 15, 10, 5, 2, 3, 20, 15, 18, 10]) !!},
                fill: false,
                borderColor: 'rgba(255, 159, 64, 1)',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
