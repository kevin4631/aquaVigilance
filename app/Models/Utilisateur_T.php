<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur_T extends Model
{
    use HasFactory;
    protected $table = 'utilisateurs_t'; // Nom de la table dans la base de données
    protected $fillable = [ 'id','longitude', 'latitude',  'libelle_commune', 'libelle_cours_eau','date_mesure_temp','resultat', ];
}
