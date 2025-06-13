<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institut Scolaire Excellence - École Primaire d'Excellence</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0f172a;
            --secondary-blue: #1e293b;
            --accent-gold: #f59e0b;
            --accent-emerald: #10b981;
            --accent-purple: #8b5cf6;
            --neutral-100: #f8fafc;
            --neutral-200: #e2e8f0;
            --neutral-300: #cbd5e1;
            --neutral-600: #475569;
            --neutral-800: #1e293b;
            --white: #ffffff;
            --gradient-primary: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            --gradient-accent: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.7;
            color: var(--neutral-800);
            background-color: var(--white);
            overflow-x: hidden;
        }

        .font-display {
            font-family: 'Playfair Display', serif;
        }

        /* Enhanced Navigation */
        .navbar-premium {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            padding: 1.25rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-premium.scrolled {
            background: rgba(15, 23, 42, 0.98);
            padding: 0.75rem 0;
            box-shadow: var(--shadow-xl);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--white) !important;
            letter-spacing: -0.025em;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 1.5rem;
            padding: 0.75rem 0 !important;
            transition: all 0.3s ease;
            position: relative;
            text-transform: capitalize;
            letter-spacing: 0.025em;
        }

        .navbar-nav .nav-link:hover {
            color: var(--accent-gold) !important;
            transform: translateY(-1px);
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: var(--gradient-accent);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }

        .navbar-nav .nav-link:hover::before {
            width: 100%;
            left: 0;
        }

        /* Hero Section with Parallax */
        .hero-premium {
            min-height: 100vh;
            background: var(--gradient-primary);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(245, 158, 11, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .hero-content {
            position: relative;
            z-index: 10;
            color: var(--white);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: var(--accent-gold);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            max-width: 600px;
        }

        .btn-premium {
            background: var(--gradient-accent);
            color: var(--white);
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
            color: var(--white);
        }

        .btn-premium:hover::before {
            left: 100%;
        }

        .btn-outline-premium {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .btn-outline-premium:hover {
            background: var(--white);
            color: var(--primary-blue);
            border-color: var(--white);
            transform: translateY(-2px);
        }

        /* Enhanced Statistics */
        .stats-premium {
            background: var(--white);
            padding: 6rem 0;
            position: relative;
        }

        .stats-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--neutral-200), transparent);
        }

        .stat-card-premium {
            background: var(--white);
            padding: 3rem 2rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--neutral-200);
            position: relative;
            overflow: hidden;
        }

        .stat-card-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-accent);
        }

        .stat-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--accent-gold);
        }

        .stat-number-premium {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
            font-family: 'Inter', sans-serif;
            line-height: 1;
        }

        .stat-label-premium {
            font-size: 1rem;
            color: var(--neutral-600);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Section Styling */
        .section-premium {
            padding: 7rem 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 5rem;
        }

        .section-badge {
            display: inline-block;
            background: var(--gradient-accent);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .section-title-premium {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .section-subtitle-premium {
            font-size: 1.125rem;
            color: var(--neutral-600);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* News Cards Enhanced */
        .news-card-premium {
            background: var(--white);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--neutral-200);
            height: 100%;
        }

        .news-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .news-header-premium {
            background: var(--gradient-primary);
            color: var(--white);
            padding: 2rem;
            position: relative;
        }

        .news-header-premium::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 10px;
            background: var(--white);
            border-radius: 1rem 1rem 0 0;
        }

        .news-date-premium {
            display: inline-flex;
            align-items: center;
            background: rgba(245, 158, 11, 0.2);
            color: var(--accent-gold);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .news-title-premium {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
            line-height: 1.3;
        }

        .news-content-premium {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Service Cards Enhanced */
        .service-card-premium {
            background: var(--white);
            padding: 3rem 2rem;
            border-radius: 1.5rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--neutral-200);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .service-card-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-accent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .service-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            color: var(--white);
        }

        .service-card-premium:hover::before {
            opacity: 1;
        }

        .service-card-premium > * {
            position: relative;
            z-index: 2;
        }

        .service-icon-premium {
            width: 80px;
            height: 80px;
            background: var(--gradient-accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--white);
            transition: all 0.3s ease;
        }

        .service-card-premium:hover .service-icon-premium {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .service-title-premium {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }

        .service-card-premium:hover .service-title-premium {
            color: var(--white);
        }

        .service-description-premium {
            color: var(--neutral-600);
            line-height: 1.7;
            transition: color 0.3s ease;
        }

        .service-card-premium:hover .service-description-premium {
            color: rgba(255, 255, 255, 0.9);
        }

        /* CTA Section Enhanced */
        .cta-premium {
            background: var(--gradient-primary);
            color: var(--white);
            padding: 8rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(245, 158, 11, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-title-premium {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .cta-subtitle-premium {
            font-size: 1.25rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Footer Enhanced */
        .footer-premium {
            background: var(--primary-blue);
            color: var(--white);
            padding: 5rem 0 2rem;
            position: relative;
        }

        .footer-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        }

        .footer-section-premium {
            margin-bottom: 3rem;
        }

        .footer-title-premium {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--accent-gold);
        }

        .footer-link-premium {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
        }

        .footer-link-premium:hover {
            color: var(--accent-gold);
            transform: translateX(5px);
        }

        .social-links-premium {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-link-premium {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .social-link-premium:hover {
            background: var(--accent-gold);
            transform: translateY(-3px);
            color: var(--white);
        }

        .footer-bottom-premium {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 3rem;
            padding-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Animation Classes */
        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .scale-up {
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scale-up.visible {
            opacity: 1;
            transform: scale(1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .btn-outline-premium {
                margin-left: 0;
                margin-top: 1rem;
            }
            
            .navbar-nav .nav-link {
                margin: 0.5rem 0;
            }
            
            .section-premium {
                padding: 4rem 0;
            }
            
            .stat-card-premium {
                margin-bottom: 2rem;
            }
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(245, 158, 11, 0.3);
            border-radius: 50%;
            border-top-color: var(--accent-gold);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        #accueil{
  background-image: url('images/i4.avif');
  background-size: cover;
  
  height:100%;
  width:100%;
  border-radius: 15px;
}

    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-premium fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#accueil">
                <i class="fas fa-graduation-cap me-2"></i>
                Institut Excellence
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#actualites">Actualités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#programmes">Programmes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#admission">Admission</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>

                    </li>
                        <span style="float: right;">
       <a href="{{ route('enseignant.login') }}" class="btn btn-primary">Login</a>
    </span>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="accueil" class="hero-premium">
        <div class="hero-bg-pattern"></div>
        <div class="container">
            <div class="row align-items-center" >
                <div class="col-lg-7">
                    <div class="hero-content">
                        <div class="hero-badge fade-up">
                            <i class="fas fa-star me-2"></i>
                            Excellence Éducative Certifiée
                        </div>
                        <h1 class="hero-title fade-up">Façonnons l'Avenir de Vos Enfants</h1>
                        <p class="hero-subtitle fade-up">Une éducation d'exception qui développe le potentiel unique de chaque élève à travers l'innovation pédagogique, l'excellence académique et l'épanouissement personnel.</p>
                        <div class="hero-actions fade-up">
                            <a href="#programmes" class="btn-premium">
                                <i class="fas fa-rocket"></i>
                                Découvrir nos programmes
                            </a>
                            <a href="#admission" class="btn-outline-premium">
                                <i class="fas fa-user-plus"></i>
                                Inscription
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-premium">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-premium scale-up">
                        <div class="stat-number-premium" data-count="450">0</div>
                        <div class="stat-label-premium">Élèves Épanouis</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-premium scale-up">
                        <div class="stat-number-premium" data-count="35">0</div>
                        <div class="stat-label-premium">Enseignants Experts</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-premium scale-up">
                        <div class="stat-number-premium" data-count="20">0</div>
                        <div class="stat-label-premium">Classes Innovantes</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card-premium scale-up">
                        <div class="stat-number-premium" data-count="99">0</div>
                        <div class="stat-label-premium">% Réussite</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="actualites" class="section-premium" style="background: var(--neutral-100);">
        <div class="container">
            <div class="section-header fade-up">
                <div class="section-badge">Actualités</div>
                <h2 class="section-title-premium">Dernières Nouvelles</h2>
                <p class="section-subtitle-premium">Restez connectés avec les événements marquants et les moments forts de notre communauté éducative</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="news-card-premium fade-up">
                        <div class="news-header-premium">
                            <div class="news-date-premium">
                                <i class="fas fa-calendar-alt me-2"></i>
                                15 Septembre 2024
                            </div>
                            <h4 class="news-title-premium">Cérémonie de Rentrée Exceptionnelle</h4>
                        </div>
                        <div class="news-content-premium">
                            <p>Une rentrée scolaire mémorable avec l'accueil de nos nouveaux élèves dans un environnement totalement rénové et équipé des dernières technologies éducatives.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="news-card-premium fade-up">
                        <div class="news-header-premium">
                            <div class="news-date-premium">
                                <i class="fas fa-calendar-alt me-2"></i>
                                22 Septembre 2024
                            </div>
                            <h4 class="news-title-premium">Journées Portes Ouvertes</h4>
                        </div>
                        <div class="news-content-premium">
                            <p>Découvrez notre campus d'exception, rencontrez nos équipes pédagogiques expertes et explorez nos programmes éducatifs innovants.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="news-card-premium fade-up">
                        <div class="news-header-premium">
                            <div class="news-date-premium">
                                <i class="fas fa-calendar-alt me-2"></i>
                                5 Octobre 2024
                            </div>
                            <h4 class="news-title-premium">Victoire au Concours National</h4>
                        </div>
                        <div class="news-content-premium">
                            <p>Nos élèves brillent au concours scientifique national, remportant les premières places en mathématiques et sciences, témoignage de notre excellence pédagogique.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="programmes" class="section-premium">
        <div class="container">
            <div class="section-header fade-up">
                <div class="section-badge">Programmes</div>
                <h2 class="section-title-premium">Excellence Éducative Intégrée</h2>
                <p class="section-subtitle-premium">Une approche pédagogique holistique qui développe les compétences académiques, créatives et sociales de chaque enfant</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card-premium fade-up">
                        <div class="service-icon-premium">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4 class="service-title-premium">Excellence Académique</h4>
                        <p class="service-description-premium">Curriculum international rigoureux avec pédagogie différenciée, développement de l'esprit critique et préparation aux défis futurs.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card-premium fade-up">
                        <div class="service-icon-premium">
                            <i class="fas fa-globe-americas"></i>
                        </div>
                        <h4 class="service-title-premium">Ouverture Internationale</h4>
                        <p class="service-description-premium">Enseignement multilingue (Arabe, Français, Anglais) avec échanges culturels et préparation aux certifications internationales.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card-premium fade-up">
                        <div class="service-icon-premium">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h4 class="service-title-premium">Innovation Numérique</h4>
                        <p class="service-description-premium">Technologies éducatives de pointe, programmation, robotique et développement des compétences numériques du 21e siècle.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card-premium fade-up">
                        <div class="service-icon-premium">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h4 class="service-title-premium">Excellence Sportive</h4>
                        <p class="service-description-premium">Programme sportif diversifié avec infrastructures modernes, développement du leadership et de l'esprit d'équipe.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card-premium fade-up">
                        <div class="service-icon-premium">
                            <i class="fas fa-theater-masks"></i>
                        </div>
                        <h4 class="service-title-premium">Arts & Expression</h4>
                        <p class="service-description-premium">Ateliers créatifs multidisciplinaires, théâtre, musique, arts plastiques pour développer la sensibilité artistique.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card-premium fade-up">
                        <div class="service-icon-premium">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <h4 class="service-title-premium">Accompagnement Personnalisé</h4>
                        <p class="service-description-premium">Suivi individualisé avec psychopédagogues, orientation personnalisée et développement du potentiel unique de chaque élève.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="admission" class="cta-premium">
        <div class="container">
            <div class="cta-content">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="cta-title-premium fade-up">Rejoignez l'Excellence</h2>
                        <p class="cta-subtitle-premium fade-up">Offrez à votre enfant une éducation d'exception qui façonnera son avenir avec confiance et détermination</p>
                        <div class="fade-up">
                            <a href="#contact" class="btn-premium btn-lg me-3">
                                <i class="fas fa-paper-plane"></i>
                                Demander une Inscription
                            </a>
                            <a href="#contact" class="btn-outline-premium btn-lg">
                                <i class="fas fa-calendar"></i>
                                Planifier une Visite
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer-premium">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section-premium">
                        <h5 class="footer-title-premium">Institut Scolaire Excellence</h5>
                        <p class="mb-4">Institution d'enseignement primaire d'élite, pionnière dans l'innovation pédagogique et l'excellence éducative au Maroc.</p>
                        <div class="social-links-premium">
                            <a href="#" class="social-link-premium">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link-premium">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link-premium">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link-premium">
                                <i class="fab fa-youtube"></i>
                            </a>
                            
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section-premium">
                        <h5 class="footer-title-premium">Contact & Localisation</h5>
                        <a href="#" class="footer-link-premium">
                            <i class="fas fa-map-marker-alt"></i>
                            Avenue Mohammed V, Quartier Administratif, Tanger
                        </a>
                        <a href="tel:+212539000000" class="footer-link-premium">
                            <i class="fas fa-phone"></i>
                            +212 539 XX XX XX
                        </a>
                        <a href="mailto:contact@institut-excellence.ma" class="footer-link-premium">
                            <i class="fas fa-envelope"></i>
                            contact@institut-excellence.ma
                        </a>
                        <a href="#" class="footer-link-premium">
                            <i class="fas fa-globe"></i>
                            www.institut-excellence.ma
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section-premium">
                        <h5 class="footer-title-premium">Horaires & Services</h5>
                        <div class="footer-link-premium">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Lundi - Vendredi:</strong> 8h00 - 17h00<br>
                                <strong>Samedi:</strong> 8h00 - 12h00<br>
                                <strong>Dimanche:</strong> Fermé
                            </div>
                        </div>
                        <a href="#" class="footer-link-premium">
                            <i class="fas fa-bus"></i>
                            Transport scolaire disponible
                        </a>
                        <a href="#" class="footer-link-premium">
                            <i class="fas fa-utensils"></i>
                            Restauration sur place
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom-premium">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; 2024 Institut Scolaire Excellence. Tous droits réservés.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0">Conçu avec passion pour l'excellence éducative</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Loading animation
        window.addEventListener('load', function() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            setTimeout(() => {
                loadingOverlay.style.opacity = '0';
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                }, 500);
            }, 1000);
        });

        // Enhanced smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Enhanced navbar scroll effect
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
            
            // Hide/show navbar on scroll
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            lastScrollTop = scrollTop;
        });

        // Enhanced intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.fade-up, .scale-up').forEach(el => {
            observer.observe(el);
        });

        // Enhanced counter animation
        function animateCounter(element, start, end, duration) {
            let startTimestamp = null;
            const suffix = element.textContent.includes('%') ? '%' : '';
            
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const current = Math.floor(progress * (end - start) + start);
                element.textContent = current + suffix;
                
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Counter animation with enhanced timing
        const counters = document.querySelectorAll('.stat-number-premium');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const finalNumber = parseInt(target.dataset.count);
                    setTimeout(() => {
                        animateCounter(target, 0, finalNumber, 2500);
                    }, 500);
                    counterObserver.unobserve(target);
                }
            });
        });

        counters.forEach(counter => {
            counterObserver.observe(counter);
        });

        // Parallax effect for hero background
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroPattern = document.querySelector('.hero-bg-pattern');
            if (heroPattern) {
                heroPattern.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Enhanced hover effects for service cards
        document.querySelectorAll('.service-card-premium').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add ripple effect to buttons
        document.querySelectorAll('.btn-premium').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            .btn-premium {
                position: relative;
                overflow: hidden;
            }
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transform: scale(0);
                animation: ripple-animation 0.6s ease-out;
                pointer-events: none;
            }
            @keyframes ripple-animation {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>