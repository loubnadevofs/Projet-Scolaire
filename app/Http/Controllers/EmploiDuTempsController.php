<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        // Définition des jours, heures et matières
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $heures = [
            '08:00 - 09:30',
            '09:45 - 11:15',
            '11:30 - 13:00',
            '14:00 - 15:30',
            '15:45 - 17:15'
        ];
        
        // Création d'un emploi du temps cohérent avec professeurs
        $matieres = [
            'Laravel' => ['prof' => 'Prof. Dupont', 'couleur' => 'primary'],
            'React Node' => ['prof' => 'Prof. Martin', 'couleur' => 'success'],
            'Python' => ['prof' => 'Prof. Bernard', 'couleur' => 'info'],
            'Base de données' => ['prof' => 'Prof. Petit', 'couleur' => 'warning'],
            'DevOps' => ['prof' => 'Prof. Robert', 'couleur' => 'danger']
        ];
        
        $salles = ['A101', 'B202', 'C303', 'D404', 'E505'];
        
        // Génération d'un emploi du temps réaliste
        $emploiDuTemps = $this->genererEmploiDuTemps($jours, $heures, $matieres, $salles);
        
        return view('emploi_du_temps.index', compact('emploiDuTemps', 'jours', 'heures'));
    }
    
    private function genererEmploiDuTemps($jours, $heures, $matieres, $salles)
    {
        $emploiDuTemps = [];
        $matieresKeys = array_keys($matieres);
        
        // Assurer que chaque matière apparaît 2-3 fois par semaine
        $distributionMatieres = [];
        foreach ($matieresKeys as $matiere) {
            $distributionMatieres[$matiere] = rand(2, 3);
        }
        
        // Initialiser l'emploi du temps vide
        foreach ($jours as $jour) {
            $emploiDuTemps[$jour] = [];
            foreach ($heures as $heure) {
                $emploiDuTemps[$jour][$heure] = null;
            }
        }
        
        // Remplir l'emploi du temps
        foreach ($distributionMatieres as $matiere => $nombreCours) {
            for ($i = 0; $i < $nombreCours; $i++) {
                $jourIndex = array_rand($jours);
                $jour = $jours[$jourIndex];
                $heure = $heures[array_rand($heures)];
                
                // Essayer de trouver un créneau libre
                $essais = 0;
                while ($emploiDuTemps[$jour][$heure] !== null && $essais < 10) {
                    $jourIndex = array_rand($jours);
                    $jour = $jours[$jourIndex];
                    $heure = $heures[array_rand($heures)];
                    $essais++;
                }
                
                if ($emploiDuTemps[$jour][$heure] === null) {
                    $emploiDuTemps[$jour][$heure] = [
                        'matiere' => $matiere,
                        'prof' => $matieres[$matiere]['prof'],
                        'salle' => $salles[array_rand($salles)],
                        'couleur' => $matieres[$matiere]['couleur']
                    ];
                }
            }
        }
        
        return $emploiDuTemps;
    }
}