<?php
// app/Models/Classe.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    protected $table = 'classes';

    protected $primaryKey = 'idClasse';
    protected $fillable = ['nom', 'niveau'];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'idClasse', 'idClasse');
    }
    // app/Models/Classe.php

public function matieres()
{
    return $this->belongsToMany(Matiere::class, 'classe_matiere', 'idClasse', 'idMatiere');
}
}