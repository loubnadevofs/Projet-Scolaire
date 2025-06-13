<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <h3>Espace Enseignant</h3>
    </div>
    
    <div class="user-info">
        <div class="user-image">
            <img src="{{ asset('images/avatars/default.png') }}" alt="Avatar" class="img-fluid rounded-circle">
        </div>
        <div class="user-details">
            <h5>{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h5>
            <span class="badge bg-primary">Enseignant</span>
        </div>
    </div>
    
    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item {{ request()->is('enseignant/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enseignant.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('enseignant/matieres*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enseignant.matieres.index') }}">
                    <i class="fas fa-book"></i>
                    <span>Mes Matières</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('enseignant/resultats*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enseignant.resultats.index') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Résultats & Notes</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('enseignant/absences*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enseignant.absences.index') }}">
                    <i class="fas fa-user-clock"></i>
                    <span>Gestion d'Absences</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('enseignant/emploi-temps*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enseignant.emploi-temps.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Emploi du temps</span>
                </a>
            </li>
            
            <li class="nav-item {{ request()->is('enseignant/documents*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('enseignant.documents.index') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Documents</span>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>
