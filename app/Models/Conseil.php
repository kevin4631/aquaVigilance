<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{
    protected $table = 'conseil';
    protected $foreignKey = 'code_cours_eau';
    public $timestamps = false;
    protected $fillable = ['code_cours_eau', 'description'];
}


