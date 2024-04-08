<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConseilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conseil', function (Blueprint $table) {
            $table->string('code_cours_eau', 50);
            $table->foreign('code_cours_eau')->references('code_cours_eau')->on('cours_eau');
            $table->string('description', 8000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conseil');
    }
}



