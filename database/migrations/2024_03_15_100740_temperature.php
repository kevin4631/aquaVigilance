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
        Schema::create('temperature', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_saisir');
            $table->integer('latitude');
            $table->integer('longitude');
            $table->string('libelle_commune', 50);
            $table->string('libelle_cours_eau', 50);
            $table->dateTime('date_mesure_temp');
            $table->integer('resultat');
        });

        
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temperature');
    }
};
