<?php

namespace App\Http\Controllers;

use App\Models\Conseil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccueilController extends Controller
{
    public function accueil()
    {
        $conseils = Conseil::all()->groupBy('code_cours_eau');
        return view("accueil", ['conseils' => $conseils]);
    }


    public function evolution() {
        return view("statistiques/evolution");
    }
}
