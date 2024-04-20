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
        Schema::create('tipo_medidas', function (Blueprint $table) {
            $table->id('tipo_med_id');
            $table->string('tipo_med_nombre', 100);
            $table->enum('tipo_med_estado', ['ACTIVO', 'INACTIVO', 'DESACTIVADO', 'ELIMINADO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_medidas');
    }
};
