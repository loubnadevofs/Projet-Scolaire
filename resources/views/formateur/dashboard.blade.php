<!-- @extends('layouts.app')
@section('content')
<div class="flex h-screen bg-gray-100">
   
    <div class="bg-blue-800 text-white w-64 flex-shrink-0 shadow-lg">
        <div class="p-4 text-center">
            <h2 class="text-xl font-bold">Espace Formateur</h2>
            <p class="text-sm mt-1">{{ $formateur->prenom }} {{ $formateur->nom }}</p>
        </div>
        <nav class="mt-6">
            <ul>
                <li class="px-4 py-3 bg-blue-900">
                    <a href="{{ route('formateur.dashboard') }}" class="flex items-center">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-blue-700">
                    <a href="{{ route('formateur.matieres') }}" class="flex items-center">
                        <i class="fas fa-book mr-3"></i>
                        <span>Mes matières</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-blue-700">
                    <a href="{{ route('formateur.emploiTemps') }}" class="flex items-center">
                        <i class="fas fa-calendar-alt mr-3"></i>
                        <span>Emploi du temps</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-blue-700">
                    <a href="{{ route('formateur.profil') }}" class="flex items-center">
                        <i class="fas fa-user mr-3"></i>
                        <span>Mon profil</span>
                    </a>
                </li>
                <li class="px-4 py-3 hover:bg-blue-700">
                    <a href="{{ route('logout') }}" class="flex items-center"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Déconnexion</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    
    <div class="flex-1 overflow-auto">
        
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
                <div class="flex items-center">
                    <span class="text-gray-600 mr-2">{{ date('d/m/Y') }}</span>
                    <i class="fas fa-bell text-gray-600 mx-4 relative">
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">3</span>
                    </i>
                </div>
            </div>
        </header>
        @if (session('success'))
            <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
           
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-book text-blue-800 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Matières</h3>
                            <p class="text-2xl font-bold">{{ $matieres->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-users text-green-800 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Étudiants</h3>
                            <p class="text-2xl font-bold">{{ $etudiantsCount }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-full">
                            <i class="fas fa-graduation-cap text-yellow-800 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Classes</h3>
                            <p class="text-2xl font-bold">{{ $classes->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded-full">
                            <i class="fas fa-user-clock text-red-800 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-gray-500 text-sm">Absences (30j)</h3>
                            <p class="text-2xl font-bold">{{ $absencesCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-700">Mes matières</h2>
                        <a href="{{ route('formateur.matieres') }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir tout</a>
                    </div>
                    <div class="p-4">
                        @if($matieres->isEmpty())
                            <p class="text-gray-500 text-center py-4">Aucune matière assignée</p>
                        @else
                            <ul class="divide-y divide-gray-200">
                                @foreach($matieres->take(5) as $matiere)
                                    <li class="py-3 flex justify-between items-center">
                                        <div>
                                            <span class="block font-medium text-gray-800">{{ $matiere->nomM }}</span>
                                            <span class="block text-sm text-gray-500">{{ $matiere->coefficient }} coefficient</span>
                                        </div>
                                        <a href="{{ route('formateur.etudiants', $matiere->idMatiere) }}" class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs">
                                            Voir étudiants
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

               
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-700">Prochains cours</h2>
                    </div>
                    <div class="p-4">
                        <ul class="divide-y divide-gray-200">
                            @php
                                $jourActuel = \Carbon\Carbon::now()->locale('fr')->isoFormat('dddd');
                                $joursOrdre = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                $jourIndex = array_search(ucfirst($jourActuel), $joursOrdre);
                            @endphp

                            @foreach($matieres->take(5) as $index => $matiere)
                                @php
                                    $jour = $joursOrdre[($jourIndex + $index) % count($joursOrdre)];
                                    $heures = ['08:00-10:00', '10:00-12:00', '14:00-16:00', '16:00-18:00'][rand(0, 3)];
                                    $classe = $classes[rand(0, count($classes) - 1)];
                                @endphp
                                <li class="py-3">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                                            <span class="font-semibold text-blue-800">{{ substr($jour, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="block font-medium text-gray-800">{{ $matiere->nomM }}</span>
                                            <div class="flex text-sm text-gray-500">
                                                <span class="mr-3"><i class="fas fa-clock mr-1"></i> {{ $heures }}</span>
                                                <span><i class="fas fa-users mr-1"></i> {{ $classe->nom }} - {{ $classe->niveau }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

           
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Mes classes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($classes as $classe)
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <h3 class="font-bold text-gray-800">{{ $classe->nom }} - {{ $classe->niveau }}</h3>
                            </div>
                            <div class="p-6">
                                @php
                                    $etudiantsClasse = App\Models\Etudiant::where('idClasse', $classe->idClasse)->count();
                                @endphp
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-gray-600"><i class="fas fa-users mr-2"></i> {{ $etudiantsClasse }} étudiants</span>
                                    <span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs">En cours</span>
                                </div>
                                @foreach($matieres as $matiere)
                                    @if(rand(0, 1) == 1)
                                        <div class="text-sm py-1">
                                            <span class="inline-block bg-blue-100 text-blue-800 rounded px-2 py-1 text-xs mr-2">{{ $matiere->nomM }}</span>
                                            @php
                                                $moyenne = rand(10, 16) + (rand(0, 99) / 100);
                                            @endphp
                                            <span class="text-gray-700">Moyenne: <span class="font-semibold">{{ number_format($moyenne, 2) }}</span></span>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Voir les détails <i class="fas fa-arrow-right ml-1"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
 -->

 {{-- resources/views/formateur/dashboard.blade.php --}}
@extends('layouts.app') {{-- أو أيّ Layout تستخدمه --}}

@section('content')
<div class="container">
    {{-- رسالة الضيف أو الترحيب بالمدرّس --}}
    @if (! auth()->check())
        <div class="alert alert-info">
            Guest sees the dashboard route is working!
        </div>
    @else
        <h1>Bienvenue, {{ $formateur->nom }} {{ $formateur->prenom }}</h1>

        <div class="row mt-4">
            {{-- عدد المواد --}}
            <div class="col-md-4">
                <div class="card border-primary mb-3">
                    <div class="card-header">Matières</div>
                    <div class="card-body text-primary">
                        <h5 class="card-title">{{ $matieres->count() }}</h5>
                        <p class="card-text">Vous enseignez {{ $matieres->count() }} matière(s).</p>
                    </div>
                </div>
            </div>

            {{-- عدد الأقسام --}}
            <div class="col-md-4">
                <div class="card border-success mb-3">
                    <div class="card-header">Classes</div>
                    <div class="card-body text-success">
                        <h5 class="card-title">{{ $classes->count() }}</h5>
                        <p class="card-text">Vous avez {{ $classes->count() }} classe(s) concernée(s).</p>
                    </div>
                </div>
            </div>

            {{-- عدد الطلاب --}}
            <div class="col-md-4">
                <div class="card border-warning mb-3">
                    <div class="card-header">Étudiants</div>
                    <div class="card-body text-warning">
                        <h5 class="card-title">{{ $etudiantsCount }}</h5>
                        <p class="card-text">{{ $etudiantsCount }} étudiant(s) suivi(s).</p>
                    </div>
                </div>
            </div>

            {{-- عدد الغيابات --}}
            <div class="col-md-4">
                <div class="card border-danger mb-3">
                    <div class="card-header">Absences (30 derniers jours)</div>
                    <div class="card-body text-danger">
                        <h5 class="card-title">{{ $absencesCount }}</h5>
                        <p class="card-text">{{ $absencesCount }} absence(s) enregistrée(s).</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
