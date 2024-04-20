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
        Schema::create('citas', function (Blueprint $table) {
            $table->id('cita_id');
            $table->unsignedBigInteger('admins_id');
            $table->unsignedBigInteger('usu_id');
            $table->date('citas_fecha');
            $table->time('citas_hora_inicio');
            $table->time('citas_hora_fin');
            $table->foreign('admins_id')->references('id')->on('admins');
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
