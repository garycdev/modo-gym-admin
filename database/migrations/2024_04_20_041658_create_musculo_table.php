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
        Schema::create('musculo', function (Blueprint $table) {
            $table->id('mus_id');
            $table->string('mus_nombre', 250);
            $table->string('mus_imagen', 250);
            $table->enum('mus_estado', ['ACTIVO', 'INACTIVO', 'DESACTIVADO', 'ELIMINADO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('musculo');
    }
};
