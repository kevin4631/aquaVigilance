<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccueilController extends Controller
{
    public function accueil()
    {
        return view("accueil");
    }
    //TO DO

    public function classement() {
        return view("statistiques/classement");
    }
}
