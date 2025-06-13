<header class="header">
    <div class="container-fluid">
        <div class="header-content">
            <!-- Toggle Sidebar Button -->
            <button id="sidebarToggle" class="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Page Title -->
            <div class="page-title">
                <h2>@yield('title', 'Tableau de bord')</h2>
            </div>
            
            <!-- Header Right -->
            <div class="header-right">
                <!-- Language Selector -->
                <div class="language-selector dropdown">
                    <button class="btn dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-globe"></i>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'fr') }}">Français</a></li>
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'ar') }}">العربية</a></li>
                        <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a></li>
                    </ul>
                </div>
                
                <!-- Notifications -->
                <div class="notifications dropdown">
                    <button class="btn dropdown-toggle" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger">3</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropdown">
                        <li class="dropdown-header">
                            <h6>Notifications</h6>
                            <a href="#">Marquer tout comme lu</a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="notification-item unread">
                            <a href="#">
                                <div class="notification-icon bg-primary">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="notification-content">
                                    <p>Nouvelle soumission de travail</p>
                                    <small>Il y a 5 minutes</small>
                                </div>
                            </a>
                        </li>
                        <li class="notification-item">
                            <a href="#">
                                <div class="notification-icon bg-success">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="notification-content">
                                    <p>Votre emploi du temps a été mis à jour</p>
                                    <small>Il y a 1 heure</small>
                                </div>
                            </a>
                        </li>
                        <li class="notification-item">
                            <a href="#">
                                <div class="notification-icon bg-info">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="notification-content">
                                    <p>Nouveau message de la direction</p>
                                    <small>Il y a 3 heures</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li class="dropdown-footer">
                            <a href="#">Voir toutes les notifications</a>
                        </li>
                    </ul>
                </div>
                
                <!-- User Menu -->
                <div class="user-menu dropdown">
                    <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/avatars/default.png') }}" alt="Avatar" class="avatar-sm rounded-circle">
                        <span class="d-none d-md-inline-block ms-2">{{ Auth::user()->prenom }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('enseignant.profile') }}"><i class="fas fa-user me-2"></i> Mon profil</a></li>
                        <li><a class="dropdown-item" href="{{ route('enseignant.settings') }}"><i class="fas fa-cog me-2"></i> Paramètres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>