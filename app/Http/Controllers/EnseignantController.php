<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matiere;
use App\Models\Etudiant;
use App\Models\Notation;
use App\Models\Absence;
use App\Models\Enseignant;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnseignantController extends Controller
{
    /**
     * Affiche le tableau de bord de l'enseignant
     */
public function dashboard()
{
    $enseignant = auth()->user()->load('matieres');

    // التحقق من أن الأستاذ متصل ومعرفه موجود
    if (!$enseignant->idEnsei) {
        abort(403, 'غير مصرح');
    }

    $classes = DB::table('enseignant_matiere_classe')
        ->join('classes', 'enseignant_matiere_classe.idClasse', '=', 'classes.idClasse')
        ->join('matieres', 'enseignant_matiere_classe.idMatiere', '=', 'matieres.idMatiere')
        ->where('enseignant_matiere_classe.idEnsei', $enseignant->idEnsei)
        ->select(
            'classes.nom as nom_classe',
            'matieres.nomM as nom_matiere',
            'classes.idClasse',
            'matieres.idMatiere'
        )
        ->get();
        $matieres = $enseignant->matieres;
        

    return view('enseignants.dashboard', compact('classes', 'enseignant','matieres'));
}
    /**
     * Get classes for the teacher
     */
 public function classes()
{
    $enseignant = auth()->guard('enseignant')->user();
    
    $classes = DB::table('enseignant_matiere_classe')
        ->join('classes', 'enseignant_matiere_classe.idClasse', '=', 'classes.idClasse')
        ->join('matieres', 'enseignant_matiere_classe.idMatiere', '=', 'matieres.idMatiere')
        ->where('enseignant_matiere_classe.idEnsei', $enseignant->idEnsei)
        ->select(
            'classes.nom as nom_classe', // or nomClasse if you prefer
            'classes.niveau', // add this if you need it
            'matieres.nomM as nom_matiere',
            'classes.idClasse',
            'matieres.idMatiere',
            DB::raw('(SELECT COUNT(*) FROM etudiants WHERE etudiants.idClasse = classes.idClasse) as etudiants_count')
        )
        ->get();
    
    return view('enseignants.classes', compact('classes'));
}

    /**
     * Affiche la liste des étudiants
     */
   public function etudiants(Request $request)
{
    $enseignant = auth()->guard('enseignant')->user();
    $classe_id = $request->input('classe_id');
    
    // Get classes with student counts
    $classes = DB::table('enseignant_matiere_classe')
        ->join('classes', 'enseignant_matiere_classe.idClasse', '=', 'classes.idClasse')
        ->join('matieres', 'enseignant_matiere_classe.idMatiere', '=', 'matieres.idMatiere')
        ->where('enseignant_matiere_classe.idEnsei', $enseignant->idEnsei)
        ->select(
            'classes.nom as nom_classe',
            'classes.niveau',
            'matieres.nomM as nom_matiere',
            'classes.idClasse',
            'matieres.idMatiere',
            DB::raw('(SELECT COUNT(*) FROM etudiants WHERE etudiants.idClasse = classes.idClasse) as etudiants_count')
        )
        ->get();
    
    // Calculate total statistics
    $totalStudents = DB::table('etudiants')
        ->whereIn('idClasse', $classes->pluck('idClasse'))
        ->count();
    
    $totalClasses = $classes->count();
    
    // Get students for selected class - now with pagination
    $etudiants = collect();
    $selectedClass = null;
    
    if ($classe_id && $classes->contains('idClasse', $classe_id)) {
        $etudiants = Etudiant::with('classe')
            ->where('idClasse', $classe_id)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->paginate(15); // Changed from get() to paginate()
            
        // Get the selected class details
        $selectedClass = (object) [
            'idClasse' => $classe_id,
            'nom' => $classes->firstWhere('idClasse', $classe_id)->nom_classe,
            'etudiants' => $etudiants
        ];
    }
    
    return view('enseignants.etudiants', [
        'classes' => $classes,
        'etudiants' => $etudiants,
        'classe_id' => $classe_id,
        'totalStudents' => $totalStudents,
        'totalClasses' => $totalClasses,
        'selectedClass' => $selectedClass
    ]);
}

    /**
     * Affiche la liste des matières enseignées
     */
    public function matieres()
    {
        $enseignant = Auth::guard('enseignant')->user();
        return view('enseignants.matieres', ['matieres' => $enseignant->matieres]);
    }

    /**
     * Affiche le formulaire pour ajouter des notes
     */
   /**
 * Affiche le formulaire pour ajouter des notes
 */
public function addResult(Request $request)
{
    $enseignant = Auth::guard('enseignant')->user();

    // Récupérer les classes et matières associées à l'enseignant, groupées par classe
    $classesMatieres = DB::table('enseignant_matiere_classe')
        ->join('classes', 'enseignant_matiere_classe.idClasse', '=', 'classes.idClasse')
        ->join('matieres', 'enseignant_matiere_classe.idMatiere', '=', 'matieres.idMatiere')
        ->where('enseignant_matiere_classe.idEnsei', $enseignant->idEnsei)
        ->select(
            'classes.idClasse',
            'classes.nom as nom_classe',
            'matieres.idMatiere',
            'matieres.nomM as nom_matiere'
        )
        ->get()
        ->groupBy('idClasse');

    // Préparer les données pour la vue : liste des classes avec leurs matières
    $classes = $classesMatieres->map(function ($items, $idClasse) {
        return (object)[
            'idClasse' => $idClasse,
            'nomClasse' => $items->first()->nom_classe,
            'matieres' => $items->pluck('nom_matiere', 'idMatiere')
        ];
    });

    $etudiants = collect();
    $selectedClasse = null;
    $selectedMatiere = null;
    $matieres = collect(); // Matières à afficher dans le select

    if ($request->has('classe_id') && $request->classe_id) {
        $selectedClasse = $request->classe_id;

        // Valider la classe
        $validClasse = $classesMatieres->has($selectedClasse);

        if ($validClasse) {
            $etudiants = Etudiant::where('idClasse', $selectedClasse)
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get();

            // Récupérer les matières pour cette classe
            $matieres = $classesMatieres->get($selectedClasse)->map(function ($item) {
                return (object)[
                    'idMatiere' => $item->idMatiere,
                    'nomMatiere' => $item->nom_matiere,
                ];
            });

            if ($request->has('matiere_id') && $request->matiere_id) {
                $selectedMatiere = $request->matiere_id;

                // Valider la matière pour cette classe
                $validMatiere = $matieres->contains(fn($m) => $m->idMatiere == $selectedMatiere);

                if (!$validMatiere) {
                    return redirect()->back()->with('error', 'Matière non valide pour cette classe');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Classe non valide');
        }
    }

    return view('enseignants.add-result', [
        'classes' => $classes,
        'etudiants' => $etudiants,
        'selectedClasse' => $selectedClasse,
        'selectedMatiere' => $selectedMatiere,
        'matieres' => $matieres,  // <-- Passe les matières ici
    ]);
}


    /**
     * Enregistre les notes
     */
    public function storeResult(Request $request)
    {
        $enseignant = Auth::guard('enseignant')->user();
        
        $request->validate([
            'classe_id' => 'required|exists:classes,idClasse',
            'matiere_id' => [
                'required',
                'exists:matieres,idMatiere',
                function ($attribute, $value, $fail) use ($enseignant) {
                    if (!$enseignant->matieres->contains('idMatiere', $value)) {
                        $fail('Vous n\'enseignez pas cette matière.');
                    }
                }
            ],
            'date_evaluation' => 'required|date',
            'type_evaluation' => 'required|in:Contrôle,Devoir,Examen,Participation',
            'etudiant_id' => 'required|array',
            'etudiant_id.*' => [
                'required',
                'exists:etudiants,idEtu',
                function ($attribute, $value, $fail) use ($request, $enseignant) {
                    $etudiant = Etudiant::find($value);
                    if (!$etudiant || $etudiant->idClasse != $request->classe_id) {
                        $fail('L\'étudiant ne fait pas partie de cette classe.');
                    }
                    
                    if (!$etudiant->classe->matieres->contains('idMatiere', $request->matiere_id)) {
                        $fail('L\'étudiant n\'étudie pas cette matière.');
                    }
                    
                    if (!$etudiant->classe->matieres()
                        ->whereHas('enseignants', function($q) use ($enseignant) {
                            $q->where('enseignants.idEnsei', $enseignant->idEnsei);
                        })->exists()) {
                        $fail('Vous n\'enseignez pas à cet étudiant.');
                    }
                }
            ],
            'note' => 'required|array',
            'note.*' => 'required|numeric|min:0|max:20',
        ]);

        try {
            DB::beginTransaction();
            
            foreach ($request->etudiant_id as $index => $etudiantId) {
                Notation::updateOrCreate(
                    [
                        'idEtu' => $etudiantId,
                        'idMatiere' => $request->matiere_id,
                        'type_evaluation' => $request->type_evaluation,
                        'dateEv' => $request->date_evaluation,
                    ],
                    [
                        'note' => $request->note[$index],
                        'annee_scolaire' => $this->getCurrentSchoolYear(),
                        'idClasse' => $request->classe_id,
                    ]
                );
            }
            
            DB::commit();
            
            return redirect()->route('enseignant.resultats')
                            ->with('success', 'Les notes ont été enregistrées avec succès.');
                            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les résultats
     */
    public function resultats(Request $request)
{
    $enseignant = auth()->guard('enseignant')->user();
    
    // Get classes through the pivot table directly
    $classes = DB::table('enseignant_matiere_classe')
        ->join('classes', 'enseignant_matiere_classe.idClasse', '=', 'classes.idClasse')
        ->where('enseignant_matiere_classe.idEnsei', $enseignant->idEnsei)
        ->select('classes.*')
        ->distinct()
        ->get();
    
    $matieres = $enseignant->matieres;
    
    $classe_id = $request->input('classe_id');
    $matiere_id = $request->input('matiere_id');
    $resultats = collect();
    
    if ($classe_id && $matiere_id) {
        // Verify the teacher teaches this matiere in this class
        $valid = DB::table('enseignant_matiere_classe')
            ->where('idEnsei', $enseignant->idEnsei)
            ->where('idClasse', $classe_id)
            ->where('idMatiere', $matiere_id)
            ->exists();
            
        if ($valid) {
            $resultats = Notation::with(['etudiant', 'matiere', 'classe'])
                ->where('idClasse', $classe_id)
                ->where('idMatiere', $matiere_id)
                ->orderBy('dateEv', 'desc')
                ->get();
        }
    }
    
    return view('enseignants.resultats', compact(
        'classes', 
        'matieres', 
        'resultats', 
        'classe_id', 
        'matiere_id'
    ));
}

 public function absences(Request $request) 
{
    $enseignant = Auth::guard('enseignant')->user();
    
    // Get all classes and subjects the teacher teaches
    $classes = DB::table('enseignant_matiere_classe')
        ->join('classes', 'enseignant_matiere_classe.idClasse', '=', 'classes.idClasse')
        ->join('matieres', 'enseignant_matiere_classe.idMatiere', '=', 'matieres.idMatiere')
        ->where('enseignant_matiere_classe.idEnsei', $enseignant->idEnsei)
        ->select(
            'classes.nom as nom_classe',
            'classes.niveau',
            'matieres.nomM as nom_matiere',
            'classes.idClasse',
            'matieres.idMatiere'
        )
        ->distinct()
        ->get();

    $classe_id = $request->input('classe_id');
    $matiere_id = $request->input('matiere_id');
    
    // récupère seulement les absences des étudiants qui suivent des matières de ce prof
    $absences = Absence::with(['etudiant', 'matiere'])
        ->whereHas('etudiant', function ($query) use ($enseignant) {
            $query->whereIn('idClasse', function($subQuery) use ($enseignant) {
                $subQuery->select('idClasse')
                         ->from('enseignant_matiere_classe')
                         ->where('idEnsei', $enseignant->idEnsei);
            });
        });

    // appliquer les filtres si sélectionnés
    if ($classe_id) {
        $absences->whereHas('etudiant', function($q) use ($classe_id) {
            $q->where('idClasse', $classe_id);
        });
    }

    // Suppression du filtre par matière car idMatiere n'existe pas dans la table absences
    // if ($matiere_id) {
    //     $absences->where('idMatiere', $matiere_id);
    // }

    $absences = $absences->orderBy('dateAbsen', 'desc')->get();

    return view('enseignants.absences', compact('classes', 'absences', 'classe_id', 'matiere_id'));
}

    /**
     * Récupère les étudiants d'une classe (API)
     */
    
   
    /**
     * Enregistre une nouvelle absence
     */




// 1. CORRECTION DE LA MÉTHODE storeAbsence
public function storeAbsence(Request $request)
{
    try {
        $validated = $request->validate([
            'etudiants' => 'required|array|min:1',
            'etudiants.*' => 'exists:etudiants,idEtu',
            'dateAbsen' => 'required|date',
            'nbrHeuAbsence' => 'required|numeric|min:1|max:8',
             'type_absence' => 'required|in:absence,retard',
            'motif' => 'nullable|string|max:500',
            'classe_id' => 'required|exists:classes,idClasse',
        ]);

        $enseignant = Auth::guard('enseignant')->user();
        
        // Vérifier que l'enseignant enseigne cette matière dans cette classe
        $valid = DB::table('enseignant_matiere_classe')
            ->where('idEnsei', $enseignant->idEnsei)
            ->where('idClasse', $validated['classe_id'])
            ->exists();
            
        if (!$valid) {
            return redirect()->back()->with('error', 'Accès non autorisé à cette classe/matière');
        }

        foreach ($validated['etudiants'] as $etudiantId) {
            Absence::create([
                'idEtu' => $etudiantId,
                'dateAbsen' => $validated['dateAbsen'],
                'nbrHeuAbsence' => $validated['nbrHeuAbsence'],
                'type_absence' => $validated['type_absence'] ?? 'absence',
                // CORRECTION: Gérer correctement la checkbox justifiee
                'justifiee' => $request->has('justifiee') ? 1 : 0,
                'motif' => $validated['motif'] ?? null
            ]);
        }

        return redirect()->route('enseignant.absences', [
            'classe_id' => $validated['classe_id'],
        ])->with('success', 'Les absences ont été enregistrées avec succès');

    } catch (ValidationException $e) {
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput()
            ->with('error', 'Erreur de validation des données');
    } catch (Exception $e) {
        \Log::error('Erreur lors de l\'ajout d\'absence: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', 'Une erreur est survenue lors de l\'enregistrement')
            ->withInput();
    }
}

// 2. CORRECTION DE LA MÉTHODE updateAbsence
public function updateAbsence(Request $request, $id)
{
    try {
        $absence = Absence::findOrFail($id);
        
        $validated = $request->validate([
            'date_absence' => 'required|date',
            'nbr_heures' => 'required|numeric|min:1|max:8',
            'type_absence' => 'nullable|in:absence,retard',
            'motif' => 'nullable|string|max:500'
        ]);
        
        // Mettre à jour avec les bons noms de colonnes
        $absence->update([
            'dateAbsen' => $validated['date_absence'],
            'nbrHeuAbsence' => $validated['nbr_heures'],
            'type_absence' => $validated['type_absence'] ?? 'absence',
            // CORRECTION: Gérer correctement la checkbox justifiee
            'justifiee' => $request->has('justifiee') ? 1 : 0,
            'motif' => $validated['motif']
        ]);

        return redirect()->back()->with('success', 'Absence modifiée avec succès');
        
    } catch (Exception $e) {
        \Log::error('Erreur lors de la modification d\'absence: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de la modification de l\'absence');
    }
}

// Dans EnseignantController.php
public function deleteAbsence($id)
{
    try {
        $absence = Absence::findOrFail($id);
        $absence->delete();
        
        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Absence supprimée avec succès']);
        }
        
        return redirect()->route('enseignant.absences')->with('success', 'Absence supprimée avec succès');
    } catch (\Exception $e) {
        if (request()->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
        }
        
        return redirect()->route('enseignant.absences')->with('error', 'Erreur lors de la suppression');
    }
}

// Correction de la méthode getEtudiantsByClasse
public function getEtudiantsByClasse($classeId)
{
    try {
        $enseignant = Auth::guard('enseignant')->user();
        
        // Vérifier que l'enseignant enseigne dans cette classe
        $hasAccess = DB::table('enseignant_matiere_classe')
            ->where('idEnsei', $enseignant->idEnsei)
            ->where('idClasse', $classeId)
            ->exists();
            
        if (!$hasAccess) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        $etudiants = Etudiant::where('idClasse', $classeId)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get(['idEtu', 'nom', 'prenom']);
        
        return response()->json($etudiants);
        
    } catch (Exception $e) {
        \Log::error('Erreur lors de la récupération des étudiants: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur serveur'], 500);
    }
}

// Correction de la méthode getMatieresByClasse
public function getMatieresByClasse($classeId)
{
    try {
        $enseignant = Auth::guard('enseignant')->user();
        
        $matieres = DB::table('enseignant_matiere_classe')
            ->join('matieres', 'enseignant_matiere_classe.idMatiere', '=', 'matieres.idMatiere')
            ->where('enseignant_matiere_classe.idClasse', $classeId)
            ->where('enseignant_matiere_classe.idEnsei', $enseignant->idEnsei)
            ->select('matieres.idMatiere', 'matieres.nomM as nom_matiere')
            ->get();

        return response()->json($matieres);
        
    } catch (Exception $e) {
        \Log::error('Erreur lors de la récupération des matières: ' . $e->getMessage());
        return response()->json(['error' => 'Erreur serveur'], 500);
    }
}

/**
 * Récupère les étudiants d'une classe via AJAX
 */
/**
 * Récupère les étudiants d'une classe via AJAX
 */
/**
 * Récupère les étudiants d'une classe via AJAX
 */


  public function getEtudiantsByClasseAndMatiere(Classe $classe, Matiere $matiere)
{
    // Récupérer les étudiants de la classe qui ont cette matière
    $etudiants = $classe->etudiants()
        ->whereHas('matieres', function($query) use ($matiere) {
            $query->where('matieres.idMatiere', $matiere->idMatiere);
        })
        ->get(['idEtu', 'nom', 'prenom']);
    
    return response()->json($etudiants);
}
/**
 * Version alternative sans vérification de sécurité (pour tester)
 */
public function getEtudiantsByClasseSimple($classeId)
{
    try {
        \Log::info("Récupération simple des étudiants pour la classe: " . $classeId);
        
        $etudiants = DB::table('etudiants')
            ->where('idClasse', $classeId)
            ->select('idEtu', 'nom', 'prenom')
            ->orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')
            ->get();

        \Log::info("Étudiants trouvés: " . $etudiants->count());
        \Log::info("Données: " . json_encode($etudiants));
        
        return response()->json($etudiants);
        
    } catch (\Exception $e) {
        \Log::error("Erreur: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

/**
 * Récupère les matières d'une classe pour un enseignant via AJAX
 */

/**
 * Génère un rapport d'absences pour une classe
 */
public function generateAbsenceReport(Request $request)
{
    $enseignant = Auth::guard('enseignant')->user();
    $classe_id = $request->input('classe_id');
    $date_debut = $request->input('date_debut');
    $date_fin = $request->input('date_fin');
    
    if (!$classe_id) {
        return redirect()->back()->with('error', 'Veuillez sélectionner une classe');
    }
    
    // Vérifier que l'enseignant enseigne cette classe
    $valid_class = DB::table('enseignant_matiere_classe')
        ->where('idEnsei', $enseignant->idEnsei)
        ->where('idClasse', $classe_id)
        ->exists();
        
    if (!$valid_class) {
        return redirect()->back()->with('error', 'Accès non autorisé à cette classe');
    }
    
    $query = DB::table('absences')
        ->join('etudiants', 'absences.idEtu', '=', 'etudiants.idEtu')
        ->where('etudiants.idClasse', $classe_id);
    
    if ($date_debut) {
        $query->where('absences.dateAbsen', '>=', $date_debut);
    }
    
    if ($date_fin) {
        $query->where('absences.dateAbsen', '<=', $date_fin);
    }
    
    $absences = $query->select(
            'etudiants.nom',
            'etudiants.prenom',
            'absences.dateAbsen',
            'absences.nbrHeuAbsence',
            'absences.type_absence',
            'absences.justifiee',
            'absences.motif'
        )
        ->orderBy('etudiants.nom')
        ->orderBy('absences.dateAbsen', 'desc')
        ->get();
    
    $classe = DB::table('classes')->where('idClasse', $classe_id)->first();
    
    // Générer le PDF ou Excel selon le besoin
    return view('enseignants.rapport_absences', compact('absences', 'classe', 'date_debut', 'date_fin'));
}

    /**
     * Affiche le profil
     */
    public function profil()
    {
        $enseignant = Auth::guard('enseignant')->user();
        return view('enseignants.profil', compact('enseignant'));
    }

    /**
     * Met à jour le profil
     */
    public function updateProfil(Request $request)
    {
        $enseignant = Auth::guard('enseignant')->user();
        
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:enseignants,email,'.$enseignant->idEnsei.',idEnsei',
            'password' => 'nullable|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
        ]);
        
        try {
            $enseignant->nom = $request->nom;
            $enseignant->prenom = $request->prenom;
            $enseignant->email = $request->email;
            
            if ($request->filled('telephone')) {
                $enseignant->telephone = $request->telephone;
            }
            
            if ($request->filled('password')) {
                $enseignant->password = bcrypt($request->password);
            }
            
            $enseignant->save();
            
            return redirect()->route('enseignants.profil')
                             ->with('success', 'Profil mis à jour');
                             
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    /**
     * Exporte les notes
     */
    public function exportNotes(Request $request)
    {
        $format = $request->get('format', 'pdf');
        return back()->with('info', 'Fonctionnalité en développement');
    }

    /**
     * Méthodes privées helpers
     */
   
    
    private function getCurrentSchoolYear()
    {
        $currentYear = now()->year;
        return (now()->month >= 9) 
            ? $currentYear . '-' . ($currentYear + 1) 
            : ($currentYear - 1) . '-' . $currentYear;
    }

    /**
 * Get students by class and matiere for quick note addition
 */



    private function getClassesForEnseignant($enseignant)
    {
        return Classe::whereHas('etudiants', function($query) use ($enseignant) {
            $query->whereHas('classe', function($classeQuery) use ($enseignant) {
                $classeQuery->whereHas('matieres', function($matiereQuery) use ($enseignant) {
                    $matiereQuery->whereHas('enseignants', function($ensQuery) use ($enseignant) {
                        $ensQuery->where('enseignants.idEnsei', $enseignant->idEnsei);
                    });
                });
            });
        })->distinct()->get();
    }

    private function getNotationsThisMonth($enseignant)
    {
        return Notation::whereHas('matiere.enseignants', function($query) use ($enseignant) {
            $query->where('enseignants.idEnsei', $enseignant->idEnsei);
        })
        ->whereMonth('dateEv', now()->month)
        ->whereYear('dateEv', now()->year)
        ->count();
    }

    private function getAbsencesThisMonth($enseignant)
    {
        return Absence::whereHas('etudiant.classe.matieres.enseignants', function($query) use ($enseignant) {
            $query->where('enseignants.idEnsei', $enseignant->idEnsei);
        })
        ->whereMonth('dateAbsen', now()->month)
        ->whereYear('dateAbsen', now()->year)
        ->count();
    }

public function updateNote(Request $request, $id)
    {
        $validated = $request->validate([
            'note' => 'required|numeric|min:0|max:20',
            'type_evaluation' => 'required|in:Contrôle,Devoir,Examen,Participation',
           
        ]);

        try {
            $note = Notation::findOrFail($id);
            
            // Vérifier que l'enseignant a le droit de modifier cette note
            if (!$this->canModifyNote($note)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas l\'autorisation de modifier cette note'
                ], 403);
            }
            
            $note->update([
                'note' => $validated['note'],
                'type_evaluation' => $validated['type_evaluation'],
                
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note mise à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer une note
     */
    public function deleteNote($id)
    {
        try {
            $note = Notation::findOrFail($id);
            
            // Vérifier que l'enseignant a le droit de supprimer cette note
            if (!$this->canModifyNote($note)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous n\'avez pas l\'autorisation de supprimer cette note'
                ], 403);
            }
            
            $note->delete();

            return response()->json([
                'success' => true,
                'message' => 'Note supprimée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer plusieurs notes
     */
    public function deleteMultipleNotes(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:notation,id'
        ]);

        try {
            $notes = Notation::whereIn('id', $request->ids)->get();
            
            // Vérifier les permissions pour chaque note
            foreach ($notes as $note) {
                if (!$this->canModifyNote($note)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous n\'avez pas l\'autorisation de supprimer certaines notes'
                    ], 403);
                }
            }
            
            $count = Notation::whereIn('id', $request->ids)->delete();

            return response()->json([
                'success' => true,
                'message' => "{$count} note(s) supprimée(s) avec succès"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Ajouter une note rapidement
     */
    public function storeQuickNote(Request $request)
{
   $validated = $request->validate([
    'classe_id' => 'required|exists:classes,idClasse',
    'matiere_id' => 'required|exists:matieres,idMatiere',
    'etudiant_id' => 'required|exists:etudiants,idEtu',
    'note' => 'required|numeric|min:0|max:20',
    'type_evaluation' => 'required|in:Contrôle,Devoir,Examen,Participation',
    'date_evaluation' => 'required|date',
    'annee_scolaire' => 'sometimes|string',  // أو 'nullable|string'
]);

if (empty($validated['annee_scolaire'])) {
    $validated['annee_scolaire'] = date('Y') . '-' . (date('Y') + 1);
}


    try {
        // Use the pivot table instead of direct Enseignant model
        $enseignement = DB::table('enseignant_matiere_classe')
            ->where('idEnsei', auth()->id()) // Use your correct column name
            ->where('idClasse', $validated['classe_id'])
            ->where('idMatiere', $validated['matiere_id'])
            ->first();
            
        if (!$enseignement) {
            return response()->json([
                'success' => false,
                'error' => 'Vous n\'enseignez pas cette matière dans cette classe'
            ], 403);
        }

            Notation::create([
                'idEtu' => $validated['etudiant_id'],
                'idClasse' => $validated['classe_id'],
                'idMatiere' => $validated['matiere_id'],
                'note' => $validated['note'],
                'dateEv' => $validated['date_evaluation'],
                'type_evaluation' => $validated['type_evaluation'],
                 'annee_scolaire' => $validated['annee_scolaire'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Note ajoutée avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de l\'ajout de la note: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Récupérer les étudiants d'une classe pour une matière
     */
 public function getStudentsByClassMatiere(Request $request)
{
    $request->validate([
        'classe_id' => 'required|exists:classes,idClasse',
        'matiere_id' => 'required|exists:matieres,idMatiere'
    ]);

    try {
        // Use the correct column names that match your database
        $enseignement = DB::table('enseignant_matiere_classe')
            ->where('idEnsei', auth()->id())  // Changed from 'enseignant_id'
            ->where('idClasse', $request->classe_id)  // Ensure this matches your DB
            ->where('idMatiere', $request->matiere_id)  // Ensure this matches your DB
            ->first();

        if (!$enseignement) {
            return response()->json([
                'error' => 'Vous n\'enseignez pas cette matière dans cette classe'
            ], 403);
        }

        $etudiants = Etudiant::where('idClasse', $request->classe_id)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get(['idEtu', 'nom', 'prenom']);

        return response()->json($etudiants);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Erreur serveur: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Vérifier si l'enseignant peut modifier/supprimer une note
     */
 private function canModifyNote($note)
{
    return DB::table('enseignant_matiere_classe')
        ->where('idEnsei', auth()->id()) // Nom exact de la colonne
        ->where('idClasse', $note->idClasse)
        ->where('idMatiere', $note->idMatiere)
        ->exists();
}


public function getEtudiantsByClasseDebug($classeId)
{
    try {
        \Log::info("DEBUG: Récupération étudiants classe " . $classeId);
        
        $etudiants = DB::table('etudiants')
            ->where('idClasse', $classeId)
            ->select('idEtu', 'nom', 'prenom')
            ->orderBy('nom')
            ->get();

        \Log::info("DEBUG: " . $etudiants->count() . " étudiants trouvés");
        
        return response()->json($etudiants->toArray());
        
    } catch (\Exception $e) {
        \Log::error("DEBUG ERROR: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }}

}