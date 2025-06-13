import React, { useState } from 'react';
import { Bell, Calendar, Book, UserCheck, Award, Settings, LogIn, Menu, X, Globe } from 'lucide-react';

export default function AccueilPage() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [language, setLanguage] = useState('fr');

  // Contenu multilingue
  const content = {
    fr: {
      title: "Système de Gestion d'Établissement Scolaire",
      subtitle: "Simplifiez la gestion scolaire et améliorez la communication",
      connexion: "Connexion",
      langues: "Langues",
      cards: {
        etudiants: {
          title: "Espace Étudiant",
          description: "Accédez à vos résultats, emplois du temps et suivez vos absences",
          button: "Accéder"
        },
        enseignants: {
          title: "Espace Enseignant",
          description: "Gérez vos cours, notez les étudiants et enregistrez les absences",
          button: "Accéder"
        },
        admin: {
          title: "Administration",
          description: "Gérez l'établissement, les utilisateurs et les emplois du temps",
          button: "Accéder"
        }
      },
      features: {
        title: "Fonctionnalités principales",
        items: [
          { 
            icon: <Book size={24} />,
            title: "Gestion des matières",
            description: "Organisez et suivez toutes les matières enseignées"
          },
          { 
            icon: <Award size={24} />,
            title: "Gestion des résultats",
            description: "Enregistrez et consultez les notes et moyennes"
          },
          { 
            icon: <UserCheck size={24} />,
            title: "Suivi des absences",
            description: "Enregistrez et suivez les absences des étudiants"
          },
          { 
            icon: <Calendar size={24} />,
            title: "Emplois du temps",
            description: "Consultez et gérez les emplois du temps"
          }
        ]
      },
      footer: {
        about: "À propos",
        contact: "Contact",
        support: "Support",
        privacy: "Confidentialité",
        copyright: "© 2025 Système de Gestion Scolaire. Tous droits réservés."
      }
    },
    en: {
      title: "School Management System",
      subtitle: "Simplify school management and improve communication",
      connexion: "Login",
      langues: "Languages",
      cards: {
        etudiants: {
          title: "Student Area",
          description: "Access your grades, schedules and track your absences",
          button: "Access"
        },
        enseignants: {
          title: "Teacher Area",
          description: "Manage your courses, grade students and record absences",
          button: "Access"
        },
        admin: {
          title: "Administration",
          description: "Manage the institution, users and schedules",
          button: "Access"
        }
      },
      features: {
        title: "Main features",
        items: [
          { 
            icon: <Book size={24} />,
            title: "Course management",
            description: "Organize and track all taught subjects"
          },
          { 
            icon: <Award size={24} />,
            title: "Results management",
            description: "Record and consult grades and averages"
          },
          { 
            icon: <UserCheck size={24} />,
            title: "Absence tracking",
            description: "Record and track student absences"
          },
          { 
            icon: <Calendar size={24} />,
            title: "Schedules",
            description: "View and manage timetables"
          }
        ]
      },
      footer: {
        about: "About",
        contact: "Contact",
        support: "Support",
        privacy: "Privacy",
        copyright: "© 2025 School Management System. All rights reserved."
      }
    },
    ar: {
      title: "نظام إدارة المؤسسات التعليمية",
      subtitle: "تبسيط إدارة المدرسة وتحسين التواصل",
      connexion: "تسجيل الدخول",
      langues: "اللغات",
      cards: {
        etudiants: {
          title: "فضاء الطالب",
          description: "الوصول إلى نتائجك وجداول مواعيدك وتتبع غياباتك",
          button: "الوصول"
        },
        enseignants: {
          title: "فضاء المدرس",
          description: "إدارة دروسك وتقييم الطلاب وتسجيل الغيابات",
          button: "الوصول"
        },
        admin: {
          title: "الإدارة",
          description: "إدارة المؤسسة والمستخدمين وجداول المواعيد",
          button: "الوصول"
        }
      },
      features: {
        title: "الميزات الرئيسية",
        items: [
          { 
            icon: <Book size={24} />,
            title: "إدارة المواد",
            description: "تنظيم ومتابعة جميع المواد التي يتم تدريسها"
          },
          { 
            icon: <Award size={24} />,
            title: "إدارة النتائج",
            description: "تسجيل ومراجعة الدرجات والمتوسطات"
          },
          { 
            icon: <UserCheck size={24} />,
            title: "متابعة الغيابات",
            description: "تسجيل ومتابعة غيابات الطلاب"
          },
          { 
            icon: <Calendar size={24} />,
            title: "جداول المواعيد",
            description: "عرض وإدارة جداول المواعيد"
          }
        ]
      },
      footer: {
        about: "حول",
        contact: "اتصل بنا",
        support: "الدعم",
        privacy: "الخصوصية",
        copyright: "© 2025 نظام إدارة المدارس. جميع الحقوق محفوظة."
      }
    }
  };

  const currentContent = content[language];

  const toggleMenu = () => {
    setIsMenuOpen(!isMenuOpen);
  };

  const changeLanguage = (lang) => {
    setLanguage(lang);
    setIsMenuOpen(false);
  };

  // Direction RTL pour l'arabe
  const pageDirection = language === 'ar' ? 'rtl' : 'ltr';

  return (
    <div dir={pageDirection} className="min-h-screen bg-gray-50 flex flex-col">
      {/* Navbar */}
      <nav className="bg-blue-600 text-white shadow-lg">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16">
            <div className="flex items-center">
              <div className="flex-shrink-0 flex items-center">
                <Book className="h-8 w-8 mr-2" />
                <span className="font-bold text-xl">EduManager</span>
              </div>
            </div>
            
            {/* Desktop Navigation */}
            <div className="hidden md:flex items-center space-x-4">
              <div className="relative">
                <button onClick={() => setIsMenuOpen(!isMenuOpen)} className="flex items-center text-white hover:text-blue-200">
                  <Globe className="h-5 w-5 mr-1" />
                  <span>{currentContent.langues}</span>
                </button>
                
                {isMenuOpen && (
                  <div className="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                    <button onClick={() => changeLanguage('fr')} className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                      Français
                    </button>
                    <button onClick={() => changeLanguage('en')} className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                      English
                    </button>
                    <button onClick={() => changeLanguage('ar')} className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                      العربية
                    </button>
                  </div>
                )}
              </div>
              
              <button className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                <LogIn className="h-4 w-4 mr-2" />
                {currentContent.connexion}
              </button>
            </div>
            
            {/* Mobile menu button */}
            <div className="flex md:hidden items-center">
              <button onClick={toggleMenu} className="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 focus:outline-none">
                {isMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
              </button>
            </div>
          </div>
        </div>
        
        {/* Mobile menu */}
        {isMenuOpen && (
          <div className="md:hidden">
            <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3">
              <div className="space-y-1">
                <button onClick={() => changeLanguage('fr')} className="block px-3 py-2 text-base font-medium text-white hover:bg-blue-700 w-full text-left">
                  Français
                </button>
                <button onClick={() => changeLanguage('en')} className="block px-3 py-2 text-base font-medium text-white hover:bg-blue-700 w-full text-left">
                  English
                </button>
                <button onClick={() => changeLanguage('ar')} className="block px-3 py-2 text-base font-medium text-white hover:bg-blue-700 w-full text-left">
                  العربية
                </button>
              </div>
              <button className="mt-4 w-full flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                <LogIn className="h-5 w-5 mr-2" />
                {currentContent.connexion}
              </button>
            </div>
          </div>
        )}
      </nav>

      {/* Hero Section */}
      <div className="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
          <div className="text-center">
            <h1 className="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
              {currentContent.title}
            </h1>
            <p className="mt-6 text-xl max-w-3xl mx-auto">
              {currentContent.subtitle}
            </p>
          </div>
        </div>
      </div>

      {/* Main Content */}
      <div className="flex-grow">
        {/* Access Cards */}
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <div className="grid md:grid-cols-3 gap-8">
            {/* Student Card */}
            <div className="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
              <div className="p-6">
                <div className="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                  <UserCheck className="h-6 w-6" />
                </div>
                <h3 className="text-lg font-medium text-gray-900">{currentContent.cards.etudiants.title}</h3>
                <p className="mt-2 text-base text-gray-500">{currentContent.cards.etudiants.description}</p>
                <div className="mt-6">
                  <button className="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    {currentContent.cards.etudiants.button}
                  </button>
                </div>
              </div>
            </div>
            
            {/* Teacher Card */}
            <div className="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
              <div className="p-6">
                <div className="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white mb-4">
                  <Book className="h-6 w-6" />
                </div>
                <h3 className="text-lg font-medium text-gray-900">{currentContent.cards.enseignants.title}</h3>
                <p className="mt-2 text-base text-gray-500">{currentContent.cards.enseignants.description}</p>
                <div className="mt-6">
                  <button className="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    {currentContent.cards.enseignants.button}
                  </button>
                </div>
              </div>
            </div>
            
            {/* Admin Card */}
            <div className="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
              <div className="p-6">
                <div className="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white mb-4">
                  <Settings className="h-6 w-6" />
                </div>
                <h3 className="text-lg font-medium text-gray-900">{currentContent.cards.admin.title}</h3>
                <p className="mt-2 text-base text-gray-500">{currentContent.cards.admin.description}</p>
                <div className="mt-6">
                  <button className="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700">
                    {currentContent.cards.admin.button}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        {/* Features Section */}
        <div className="bg-gray-100 py-12">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center">
              <h2 className="text-3xl font-extrabold text-gray-900">{currentContent.features.title}</h2>
            </div>
            
            <div className="mt-10">
              <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                {currentContent.features.items.map((feature, index) => (
                  <div key={index} className="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow duration-300">
                    <div className="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mb-4">
                      {feature.icon}
                    </div>
                    <h3 className="text-lg font-medium text-gray-900">{feature.title}</h3>
                    <p className="mt-2 text-sm text-gray-500">{feature.description}</p>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Footer */}
      <footer className="bg-gray-800 text-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider">{currentContent.footer.about}</h3>
              <div className="mt-4 space-y-4">
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Mission
                </a>
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Vision
                </a>
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Team
                </a>
              </div>
            </div>
            
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider">{currentContent.footer.support}</h3>
              <div className="mt-4 space-y-4">
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  FAQ
                </a>
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Documentation
                </a>
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Tutoriels
                </a>
              </div>
            </div>
            
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider">{currentContent.footer.contact}</h3>
              <div className="mt-4 space-y-4">
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Email
                </a>
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Téléphone
                </a>
              </div>
            </div>
            
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider">{currentContent.footer.privacy}</h3>
              <div className="mt-4 space-y-4">
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  RGPD
                </a>
                <a href="#" className="text-base text-gray-300 hover:text-white block">
                  Mentions légales
                </a>
              </div>
            </div>
          </div>
          
          <div className="mt-8 border-t border-gray-700 pt-8 md:flex md:items-center md:justify-between">
            <div className="flex space-x-6 md:order-2">
              <a href="#" className="text-gray-400 hover:text-gray-300">
                <span className="sr-only">Facebook</span>
                <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fillRule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clipRule="evenodd" />
                </svg>
              </a>
              <a href="#" className="text-gray-400 hover:text-gray-300">
                <span className="sr-only">Twitter</span>
                <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                </svg>
              </a>
              <a href="#" className="text-gray-400 hover:text-gray-300">
                <span className="sr-only">Instagram</span>
                <svg className="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                  <path fillRule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clipRule="evenodd" />
                </svg>
              </a>
            </div>
            <p className="mt-8 text-base text-gray-400 md:mt-0 md:order-1">
              {currentContent.footer.copyright}
            </p>
          </div>
        </div>
      </footer>
    </div>
  );
}