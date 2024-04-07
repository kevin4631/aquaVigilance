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
        Schema::create('association_region_eau', function (Blueprint $table) {
            $table->string('code_region', 50);
            $table->string('code_cours_eau', 50);
            $table->primary(['code_region', 'code_cours_eau']); 
            $table->foreign('code_cours_eau')->references('code_cours_eau')->on('cours_eau');
            $table->foreign('code_region')->references('code_region')->on('region');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_region_eau');
    }
};
