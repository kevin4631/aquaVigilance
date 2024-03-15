<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('utilisateur_T', function (Blueprint $table) {
            $table->id();
            $table->decimal('longitude', 10, 8);
            $table->decimal('latitude', 10, 8);
            $table->string('libelle_commune');
            $table->string('libelle_cours_eau');
            $table->date('date_mesure_temp');
            $table->time('heure_mesure_temp');
            $table->string('resultat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateur__t');
    }
};
