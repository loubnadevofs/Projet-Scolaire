<?php

// app/Http/Controllers/MatiereController.php
namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    /**
     * Display a listing of subjects.
     */
    public function index(Request $request)
{
    $query = Matiere::query();
    
    // Recherche par nom
    if ($request->filled('search')) {
        $query->where('nomM', 'like', '%' . $request->search . '%');
    }
    
    // Tri
    $sortBy = $request->get('sort_by', 'nomM');
    $query->orderBy($sortBy, 'asc');
    
    $matieres = $query->get();
    
    return view('matieres.index', compact('matieres'));
}

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        return view('matieres.create');
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomM' => 'required|string|max:50',
            'coefficient' => 'required|integer|min:0',
        ]);

        Matiere::create($request->all());

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière créée avec succès');
    }

    /**
     * Display the specified subject.
     */
    public function show(Matiere $matiere)
    {
        $matiere->load('enseignants');
        return view('matieres.show', compact('matiere'));
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit(Matiere $matiere)
    {
        return view('matieres.edit', compact('matiere'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'nomM' => 'required|string|max:50',
            'coefficient' => 'required|integer|min:0',
        ]);

        $matiere->update($request->all());

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière mise à jour avec succès');
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy($id)

    {  $matiere=Matiere ::findOrFail($id);
        $matiere->delete();

        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière supprimée avec succès');
    }
}