<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CoursEau extends Model
{
    protected $table = 'cours_eau';
    public $timestamps = false;
    protected $primaryKey = 'code_cours_eau';
    public $incrementing = false; // pas d'incrémentation auto car la clé primaire c'est du string et pas INT
    protected $fillable = ['code_cours_eau', 'libelle'];
}
