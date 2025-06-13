<?php
namespace App\Http\Controllers;
use App\Models\Notation;
use App\Models\Etudiant;
use App\Models\Matiere;
use Illuminate\Http\Request;
class NotationController extends Controller
{
  public function index(Request $request)
{
    $query = Notation::with(['etudiant', 'matiere']);
    
    // Recherche par matière
    if ($request->filled('search_matiere')) {
        $query->whereHas('matiere', function($q) use ($request) {
            $q->where('nomM', 'like', '%' . $request->search_matiere . '%');
        });
    }
    
    // Filtre par année scolaire
    if ($request->filled('annee_scolaire')) {
        $query->where('annee_scolaire', $request->annee_scolaire);
    }
    
    $notations = $query->orderBy('dateEv', 'desc')->get();
    
    return view('notations.index', compact('notations'));
}

    public function create()
    {
        $etudiants = Etudiant::all();
        $matieres = Matiere::all();
        return view('notations.create', compact('etudiants', 'matieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idEtu' => 'required|exists:etudiants,idEtu',
            'idMatiere' => 'required|exists:matieres,idMatiere',
            'note' => 'required|numeric|min:0|max:20',
            'dateEv' => 'required|date',
            'annee_scolaire' => 'required|string|max:20',
        ]);

        Notation::create($request->all());

        return redirect()->route('admin.notations.index')->with('success', 'Note ajoutée avec succès');
    }

    public function show($id)
    {
        $notation = Notation::with(['etudiant', 'matiere'])->findOrFail($id);
        return view('notations.show', compact('notation'));
    }

    public function edit($id)
    {
        $notation = Notation::findOrFail($id);
        $etudiants = Etudiant::all();
        $matieres = Matiere::all();
        return view('notations.edit', compact('notation', 'etudiants', 'matieres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idEtu' => 'required|exists:etudiants,idEtu',
            'idMatiere' => 'required|exists:matieres,idMatiere',
            'note' => 'required|numeric|min:0|max:20',
            'dateEv' => 'required|date',
            'annee_scolaire' => 'required|string|max:20',
        ]);

        $notation = Notation::findOrFail($id);
        $notation->update($request->all());

        return redirect()->route('admin.notations.index')->with('success', 'Note mise à jour avec succès');
    }

    public function destroy($id)
    {
        $notation = Notation::findOrFail($id);
        $notation->delete();

        return redirect()->route('admin.notations.index')->with('success', 'Note supprimée avec succès');
    }
}