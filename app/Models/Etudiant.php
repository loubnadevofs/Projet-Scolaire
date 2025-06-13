<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $primaryKey = 'idEtu';
    protected $fillable = ['nom', 'prenom', 'idClasse', 'dateNaissance'];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'idClasse');
    }

    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'notations', 'idEtu', 'idMatiere')
                    ->withPivot(['note', 'dateEv', 'annee_scolaire'])
                    ->withTimestamps();
    }

    public function absences()
    {
        return $this->hasMany(Absence::class, 'idEtu');
    }

    public function notations()
    {
        return $this->hasMany(Notation::class, 'idEtu', 'idEtu');
    }
 
}

