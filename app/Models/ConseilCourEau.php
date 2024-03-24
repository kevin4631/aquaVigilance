<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


//association_conseil_eau

class ConseilCourEau extends Model
{

    protected $table = 'association_conseil_eau';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['code_cours_eau', 'id'];

    // définir les relations
    public function coursEau()
    {
        return $this->belongsTo(CoursEau::class, 'code_cours_eau', 'code_cours_eau');
    }

    public function conseil()
    {
        return $this->belongsTo(Conseil::class, 'id', 'id');
    }
}
