<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{

    protected $table = 'temperature'; //  // nom table
    protected $primaryKey = 'id'; /// clé primaire de la table
    protected $foreignKey = 'id_saisir'; // clé étrangère
    public $incrementing = true; // incrémentation
    protected $keyType = 'string';
    public $timestamps = false; // pour éviter le created at et update ..

    // les champs qu'on peut remplir
    protected $fillable = [
        'latitude', 'longitude', 'libelle_commune',
        'libelle_cours_eau', 'date_mesure_temp',
        'resultat', 'id', 'id_saisir'
    ];

}
