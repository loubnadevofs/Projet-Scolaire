<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FormateurController extends Controller
{
   public function index()
{
    $enseignants = Enseignant::with('matieres')->get();
    return view('formateurs.index', compact('enseignants'));
}

    public function create()
    {
        $matieres = Matiere::all();
        return view('formateurs.create', compact('matieres'));
    }

   public function store(Request $request)
{
    $enseignant = new Enseignant();
    $enseignant->nom = $request->nom;
    $enseignant->prenom = $request->prenom;
    $enseignant->email = $request->email;
    $enseignant->password = bcrypt($request->password); // Important de hasher le mot de passe
    $enseignant->save();

    return redirect()->route('admin.enseignants.index')->with('success', 'Formateur ajouté avec succès.');
}


    public function show($id)
    {
       $enseignant = Enseignant::with(['matieres', 'classes'])->findOrFail($id);
        return view('formateurs.show', compact('enseignant'));
    }

    public function edit($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $matieres = Matiere::all();
        return view('formateurs.edit', compact('enseignant', 'matieres'));
    }

    public function update(Request $request, $id)
{
    $enseignant = Enseignant::findOrFail($id);
    
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:enseignants,email,' . $id . ',idEnsei',
       
    ]);
    
    $enseignant->nom = $request->nom;
    $enseignant->prenom = $request->prenom;
    $enseignant->email = $request->email;
   
    
    if ($request->filled('password')) {
        $enseignant->password = Hash::make($request->password);
    }
    
    $enseignant->save();
    
    return redirect()->route('admin.enseignants.index')->with('success', 'Formateur modifié avec succès');
}

    public function destroy($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        $enseignant->delete();

        return redirect()->route('admin.enseignants.index')->with('success', 'Formateur supprimé avec succès');
    }
}
