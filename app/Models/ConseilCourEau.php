<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConseilCourEau extends Model
{
    protected $table = 'association_conseil_eau';
    protected $primaryKey = ['code_cours_eau', 'conseil_id'];
    protected $foreignKey = 'conseil_id';
    public $incrementing = true; 
    public $timestamps = false; 

    protected $fillable = ['code_cours_eau', 'conseil_id'];

   
}
