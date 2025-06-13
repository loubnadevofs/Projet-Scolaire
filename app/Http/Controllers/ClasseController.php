<?php

// app/Http/Controllers/ClasseController.php
namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of classes.
     */
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'niveau' => 'required|string|max:50',
        ]);

        Classe::create($request->all());

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe créée avec succès');
    }

    /**
     * Display the specified class.
     */
    public function show($id)
    {
        $classe= Classe::findOrFail($id);
        return view('classes.show', compact('classe'));
    }
    
    /**
     * Show the form for editing the specified class.
     */
    public function edit($id)
    {
        $classe = Classe::findOrFail($id);
        return view('classes.edit', compact('classe'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'niveau' => 'required|string|max:255',
    ]);

    // Recherche de la classe à mettre à jour
    $classe = Classe::findOrFail($id);

    // Mise à jour de la classe
    $classe->update([
        'nom' => $request->input('nom'),
        'niveau' => $request->input('niveau'),
    ]);

    // Retourner la réponse
    return redirect()->route('admin.classes.index')->with('success', 'Classe mise à jour avec succès');
}

    
    /**
     * Remove the specified class from storage.
     */
    public function destroy($id)

    { 
        $classe=Classe::findOrFail($id);
        $classe->delete();

        return redirect()->route('admin.classes.index')
            ->with('success', 'Classe supprimée avec succès');
    }
}
