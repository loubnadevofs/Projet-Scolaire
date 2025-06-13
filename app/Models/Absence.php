<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absence extends Model
{
    use HasFactory;
    
    // Définir la clé primaire
    protected $primaryKey = 'idA';
    
    // Spécifier si la clé primaire est un incrément automatique
    public $incrementing = true;
    
    // Définir le type de la clé primaire
    protected $keyType = 'integer';
    
    // Désactiver les timestamps si nécessaire
    // public $timestamps = false;
    
    // Définir les attributs qui sont assignables en masse
   protected $fillable = [
    'idEtu',
    'dateAbsen',
    'nbrHeuAbsence',
    'type_absence',
    'justifiee',
    'motif'];
    
    // Relation avec le modèle Etudiant
    // Modèle Absence
public function etudiant()
{
    return $this->belongsTo(Etudiant::class, 'idEtu', 'idEtu');
}
// In Absence.php
public function classe()
{
    // Assuming Etudiant has a classe relationship
    return $this->hasOneThrough(
        Classe::class,
        Etudiant::class,
        'idEtu', // Foreign key on Etudiant table
        'idClasse', // Foreign key on Classe table
        'idEtu', // Local key on Absence table
        'idClasse' // Local key on Etudiant table
    );
}
public function matiere()
{
    return $this->belongsToMany(
        Matiere::class,
        'enseignant_matiere_classe', // pivot table
        'idClasse',                  // foreign key on pivot table
        'idMatiere',                 // foreign key on target table
        'idClasse',                  // local key (from classe through etudiant)
        'idMatiere'                  // local key on pivot
    );}

}