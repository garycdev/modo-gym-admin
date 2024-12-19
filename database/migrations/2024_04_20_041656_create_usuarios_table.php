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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usu_id');
            $table->string('usu_nombre')->default('SIN NOMBRE');
            $table->string('usu_apellidos')->nullable();
            $table->integer('usu_ci');
            $table->integer('usu_celular')->nullable();
            $table->string('usu_email')->nullable();
            $table->boolean('usu_huella')->default(false);
            $table->integer('usu_edad')->default(0);
            $table->enum('usu_genero', ['MASCULINO', 'FEMENINO', 'NO PREFIERO DECIRLO']);
            $table->string('usu_imagen')->nullable();
            $table->enum('usu_nivel', ['BASICO', 'INTERMEDIO', 'AVANZADO']);
            $table->text('usu_ante_medicos')->nullable();
            $table->text('usu_lesiones')->nullable();
            $table->text('usu_objetivo')->nullable();
            $table->integer('usu_frecuencia')->nullable();
            $table->integer('usu_hora')->nullable();
            $table->text('usu_deportes')->nullable();
            $table->enum('usu_estado', ['ACTIVO', 'INACTIVO', 'DESACTIVADO', 'ELIMINADO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
