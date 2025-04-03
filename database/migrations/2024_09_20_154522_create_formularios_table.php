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
        Schema::create('formularios', function (Blueprint $table) {
            $table->id('id_formulario');
            $table->unsignedBigInteger('usu_id');
            $table->string('inscrito')->nullable();
            $table->string('nombre_completo');
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('direccion')->nullable();
            $table->string('correo')->nullable();
            $table->text('medicamentos')->nullable();
            $table->text('enfermedades')->nullable();
            $table->string('referencia')->nullable();
            $table->string('entrenamiento')->nullable();
            $table->string('horario')->nullable();
            $table->string('dias_semana')->nullable();
            $table->string('nivel_entrenamiento')->nullable();
            $table->text('lesion')->nullable();
            $table->json('objetivos')->nullable();
            $table->text('deportes_detalles')->nullable();
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
