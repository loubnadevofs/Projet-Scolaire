<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    /**
     * Display a listing of absences.
     */
    public function index()
    {
        $absences = Absence::with('etudiant')->get();
        return view('absences.index', compact('absences'));
    }

    /**
     * Show the form for creating a new absence.
     */
   /*  public function create()
    {
        $etudiants = Etudiant::all();
        return view('absences.create', compact('etudiants'));
    } */

    /**
     * Store a newly created absence in storage.
     */
   /*  public function store(Request $request)
    {
        $request->validate([
            'idEtu' => 'required|exists:etudiants,idEtu',
            'dateAbsen' => 'required|date',
            'nbrHeuAbsence' => 'required|numeric|min:0',
        ]);

        Absence::create($request->all());

        return redirect()->route('admin.absences.index')
            ->with('success', 'Absence enregistrée avec succès');
    }
 */
    /**
     * Display the specified absence.
     */
    /* public function show($id)
    {
        $absence = Absence::with('etudiant')->findOrFail($id);
        return view('absences.show', compact('absence'));
    } */

    /**
     * Show the form for editing the specified absence.
     */
    /* public function edit($id)
    {
        $absence = Absence::findOrFail($id);
        $etudiants = Etudiant::all();
        return view('absences.edit', compact('absence', 'etudiants'));
    } */

    /**
     * Update the specified absence in storage.
     */
  /*   public function update(Request $request, $id)
    {
        $request->validate([
            'idEtu' => 'required|exists:etudiants,idEtu',
            'dateAbsen' => 'required|date',
            'nbrHeuAbsence' => 'required|numeric|min:0',
        ]);

        $absence = Absence::findOrFail($id);
        $absence->update($request->all());

        return redirect()->route('admin.absences.index')
            ->with('success', 'Absence mise à jour avec succès');
    }
 */
    /**
     * Remove the specified absence from storage.
     */
   /*  public function destroy($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->delete();

        return redirect()->route('admin.absences.index')
            ->with('success', 'Absence supprimée avec succès');
    } */
}