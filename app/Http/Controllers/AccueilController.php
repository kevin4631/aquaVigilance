<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function evolution() {
        return view("statistiques/evolution");
    }
}
