<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


// association region_cours_eau
class RegionCoursEau extends Model
{
    protected $table = 'association_region_eau';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['code_cours_eau', 'code_region'];

    //  définir les relations
    public function coursEau()
    {
        return $this->belongsTo(CoursEau::class, 'code_cours_eau', 'code_cours_eau');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'code_region', 'code_region');
    }
}
