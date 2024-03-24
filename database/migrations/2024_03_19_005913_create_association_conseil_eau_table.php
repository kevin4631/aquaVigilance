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
        Schema::create('association_conseil_eau', function (Blueprint $table) {
            $table->string('code_cours_eau', 50);
            $table->unsignedBigInteger('id');
            $table->primary(['code_cours_eau', 'id']);
            $table->foreign('code_cours_eau')->references('code_cours_eau')->on('cours_eau');
            $table->foreign('id')->references('id')->on('conseil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('association_conseil_eau');
    }
};
