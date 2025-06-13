<?php

// 1. Make sure your Notation model exists and is properly configured
// app/Models/Notation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory;

    protected $table = 'notations';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'idEtu',
        'idMatiere', 
        'idClasse',
        'note',
        'type_evaluation',
        'dateEv',
        'annee_scolaire'
    ];

    protected $casts = [
        'dateEv' => 'date',
        'note' => 'decimal:2'
    ];

    // Relations
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'idEtu', 'idEtu');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'idMatiere', 'idMatiere');
    }

   public function classe()
    {
        return $this->belongsTo(Classe::class, 'idClasse', 'idClasse');
    }
}