<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region';
    public $timestamps = false;
    protected $primaryKey = 'code_region';
    public $incrementing = false;
    protected $fillable = ['code_region', 'libelle'];
}
