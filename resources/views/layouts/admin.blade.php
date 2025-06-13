<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3490dc;
            --secondary: #6c757d;
            --success: #38c172;
            --danger: #e3342f;
            --warning: #f6993f;
            --info: #6cb2eb;
            --light: #f8f9fa;
            --dark: rgb(37, 61, 84);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
        }

        .sidebar {
            background-color: var(--dark);
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            transition: all 0.3s;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .sidebar-logo p {
            margin-top: 10px;
            margin-bottom: 0;
            font-weight: 600;
            color: #6cb2eb;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu ul li {
            position: relative;
            margin-bottom: 5px;
        }

        .sidebar-menu ul li a {
            padding: 12px 20px;
            color: #ccc;
            display: block;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
            position: relative;
        }

        .sidebar-menu ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar-menu ul li a:hover,
        .sidebar-menu ul li a.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            margin: 0 10px;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
            min-height: 100vh;
        }

        .content-wrapper.expanded {
            margin-left: 70px;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .navbar .dropdown-menu {
            right: 0;
            left: auto;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
        }

        .card-stats {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .card-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-stats .icon {
            font-size: 40px;
            opacity: 0.7;
        }

        /* RTL Support */
        .rtl .sidebar {
            right: 0;
            left: auto;
        }

        .rtl .content-wrapper {
            margin-right: 250px;
            margin-left: 0;
        }

        .rtl .content-wrapper.expanded {
            margin-right: 70px;
            margin-left: 0;
        }

        .rtl .sidebar-menu ul li a i {
            margin-left: 10px;
            margin-right: 0;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .content-wrapper {
                margin-left: 0;
            }
            
            .rtl .sidebar {
                transform: translateX(100%);
            }
            
            .rtl .sidebar.active {
                transform: translateX(0);
            }
            
            .rtl .content-wrapper {
                margin-right: 0;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar.collapsed .sidebar-logo p,
            .sidebar.collapsed .sidebar-menu ul li a span {
                display: none;
            }
            
            .sidebar.collapsed .sidebar-logo {
                padding: 15px 10px;
            }
            
            .sidebar.collapsed .sidebar-menu ul li a {
                padding: 12px 15px;
                text-align: center;
            }
        }

        /* Additional utility classes */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo1.png') }}" alt="School Logo">
            <p>School</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>{{ __('Tableau de bord') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.etudiants.index') }}" class="{{ request()->routeIs('admin.etudiants.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i>
                        <span>{{ __('Étudiants') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.enseignants.index') }}" class="{{ request()->routeIs('admin.enseignants.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>{{ __('Enseignants') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.classes.index') }}" class="{{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                        <i class="fas fa-school"></i>
                        <span>{{ __('Classes') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.matieres.index') }}" class="{{ request()->routeIs('admin.matieres.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>{{ __('Matières') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.notations.index') }}" class="{{ request()->routeIs('admin.notations.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>{{ __('Résultats') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.absences.index') }}" class="{{ request()->routeIs('admin.absences.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-times"></i>
                        <span>{{ __('Absences') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="content-wrapper" id="contentWrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button class="btn btn-dark d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <button class="btn btn-outline-dark d-none d-lg-block" id="sidebarCollapse">
                    <i class="fas fa-angle-left"></i>
                </button>
                
                <div class="ms-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Auth::check())
                                    <i class="fas fa-user-circle me-2"></i> {{ Auth::user()->name }}
                                @else
                                    <i class="fas fa-user-circle me-2"></i> {{ __('Guest') }}
                                @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user me-2"></i>{{ __('Profil') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cog me-2"></i>{{ __('Paramètres') }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('enseignant.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>{{ __('Déconnexion') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid fade-in">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('contentWrapper');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            
            // Mobile sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
            
            // Desktop sidebar collapse
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    contentWrapper.classList.toggle('expanded');
                    
                    // Change icon direction
                    const icon = this.querySelector('i');
                    if (sidebar.classList.contains('collapsed')) {
                        icon.classList.remove('fa-angle-left');
                        icon.classList.add('fa-angle-right');
                    } else {
                        icon.classList.remove('fa-angle-right');
                        icon.classList.add('fa-angle-left');
                    }
                });
            }
            
            // Close mobile sidebar when clicking outside
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>