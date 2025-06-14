<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'idMatiere';
    
    protected $fillable = [
        'nomM',
        'coefficient',
    ];
    
    public function enseignants()
    {
        return $this->belongsToMany(
            Enseignant::class, 
            'enseignant_matiere', 
            'idMatiere', 
            'idEnsei'
        );
    }
}
