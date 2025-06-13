<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Matiere;
use App\Models\Notation;
use App\Models\Absence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $totalEtudiants = Etudiant::count();
        $totalEnseignants = Enseignant::count();
        $totalMatieres = Matiere::count();
        $totalAbsences = Absence::count();
        
        // Données récentes
        $recentEtudiants = Etudiant::with('classe')->orderBy('created_at', 'desc')->take(5)->get();
        $recentNotations = Notation::with(['etudiant', 'matiere'])->orderBy('dateEv', 'desc')->take(5)->get();
        
        // Données pour les graphiques
        $chartMatieres = Matiere::pluck('nomM')->toArray();
        $chartNotes = [];
        
        foreach ($chartMatieres as $matiere) {
            $chartNotes[] = Notation::whereHas('matiere', function($query) use ($matiere) {
                $query->where('nomM', $matiere);
            })->avg('note') ?? 0;
        }
        
        $chartMois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        $chartAbsences = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $chartAbsences[] = Absence::whereMonth('dateAbsen', $i)->count();
        }
        
        return view('admin.dashboard', compact(
            'totalEtudiants', 
            'totalEnseignants', 
            'totalMatieres', 
            'totalAbsences',
            'recentEtudiants',
            'recentNotations',
            'chartMatieres',
            'chartNotes',
            'chartMois',
            'chartAbsences'
        ));
    }
}