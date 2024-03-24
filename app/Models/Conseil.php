<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{

    protected $table = 'conseil'; // nom table
    protected $primaryKey = 'id'; // clé primaire de la table
    public $incrementing = true; // incrémentation
    protected $keyType = 'string';
    public $timestamps = false; // pour éviter le created at et update ..

    protected $fillable = [
        'id', 'description'
    ];
}
