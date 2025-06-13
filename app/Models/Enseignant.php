<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Enseignant extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $primaryKey = 'idEnsei';
    
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

 // App\Models\Enseignant.php

public function matieres()
{
    return $this->belongsToMany(Matiere::class, 'enseignant_matiere_classe', 'idEnsei', 'idMatiere')
                ->withPivot('idClasse');
}

public function classes()
{
    return $this->belongsToMany(Classe::class, 'enseignant_matiere_classe', 'idEnsei', 'idClasse')
                ->withPivot('idMatiere');
}
    // العلاقة مع جدول النوتاسيون (حسب تصميمك)
    public function notations()
    {
        return $this->hasMany(Notation::class, 'idEnsei');
    }


}
