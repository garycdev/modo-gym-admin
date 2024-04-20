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
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id('ejer_id');
            $table->string('ejer_nombre', 250)->nullable();
            $table->string('ejer_imagen', 250)->nullable();
            $table->text('ejer_descripcion')->nullable();
            $table->tinyInteger('ejer_nivel')->default(0);
            $table->unsignedBigInteger('equi_id')->nullable();
            $table->unsignedBigInteger('mus_id')->nullable();
            $table->enum('ejer_estado', ['ACTIVO', 'INACTIVO', 'DESACTIVADO', 'ELIMINADO'])->default('ACTIVO');
            $table->timestamps();

            // Foreign keys
            $table->foreign('equi_id')->references('equi_id')->on('equipos');
            $table->foreign('mus_id')->references('mus_id')->on('musculo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
};
