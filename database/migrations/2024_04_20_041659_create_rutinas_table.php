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
        Schema::create('rutinas', function (Blueprint $table) {
            $table->bigIncrements('rut_id');
            $table->unsignedBigInteger('usu_id');
            $table->unsignedBigInteger('ejer_id');
            $table->integer('rut_serie')->default(0);
            $table->integer('rut_repeticiones')->default(0);
            $table->integer('rut_peso')->default(0);
            $table->integer('rut_rid')->default(0);
            $table->integer('rut_tiempo')->default(0);
            $table->tinyInteger('rut_dia');
            $table->date('rut_date_ini');
            $table->date('rut_date_fin');
            $table->enum('rut_estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();

            $table->foreign('ejer_id')->references('ejer_id')->on('ejercicios');
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutinas');
    }
};
