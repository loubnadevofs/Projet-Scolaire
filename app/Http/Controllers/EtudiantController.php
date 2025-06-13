<?php

// app/Http/Controllers/EtudiantController.php
namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Classe;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index()
    {
        $etudiants = Etudiant::with('classe')->get();

        return view('etudiants.index', compact('etudiants'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $classes = Classe::all();
        return view('etudiants.create', compact('classes'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'idClasse' => 'required|exists:classes,idClasse',
            'dateNaissance' => 'required|date',
        ]);

        Etudiant::create($request->all());

        return redirect()->route('admin.etudiants.index')
            ->with('success', 'Étudiant créé avec succès');
    }

    /**
     * Display the specified student.
     */
    public function show(Etudiant $etudiant)
    {
        $etudiant->load(['classe', 'notations.matiere', 'absences']);
        return view('etudiants.show', compact('etudiant'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Etudiant $etudiant)
    {
        $classes = Classe::all();
        return view('etudiants.edit', compact('etudiant', 'classes'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'idClasse' => 'required|exists:classes,idClasse',
            'dateNaissance' => 'required|date',
        ]);

        $etudiant->update($request->all());

        return redirect()->route('admin.etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();

        return redirect()->route('admin.etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès');
    }
}