<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conseil extends Model
{
    protected $table = 'conseil';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false; // dsactivé timestamps 
    protected $fillable = ['description'];
}


