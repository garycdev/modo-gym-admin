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
        Schema::create('rutinas_defecto', function (Blueprint $table) {
            $table->bigIncrements('rd_id');
            $table->unsignedBigInteger('def_id');
            $table->foreign('def_id')->references('def_id')->on('defecto');
            $table->unsignedBigInteger('ejer_id');
            $table->foreign('ejer_id')->references('ejer_id')->on('ejercicios');
            $table->integer('rut_serie')->default(0);
            $table->integer('rut_repeticiones')->default(0);
            // $table->integer('rut_peso')->default(0);
            $table->integer('rut_rid')->default(0);
            // $table->integer('rut_tiempo')->default(0);
            $table->tinyInteger('rut_dia');
            // $table->date('rut_date_ini');
            // $table->date('rut_date_fin');
            $table->enum('rut_estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutinas_defecto');
    }
};
