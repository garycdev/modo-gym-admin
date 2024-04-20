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
        Schema::create('informacion_empresa', function (Blueprint $table) {
            $table->id('informacion_id');
            $table->string('info_nombre', 250)->nullable();
            $table->string('info_logo', 250)->nullable();
            $table->text('info_descripcion')->nullable();
            $table->string('info_video_url', 250)->nullable();
            $table->string('info_telefono_1', 100)->nullable();
            $table->string('info_contacto_1', 100)->nullable();
            $table->string('info_contacto_2', 100)->nullable();
            $table->string('info_contacto_3', 100)->nullable();
            $table->string('info_atencion', 250)->nullable();
            $table->string('info_correo', 250)->nullable();
            $table->string('info_facebook', 250)->nullable();
            $table->string('info_tiktok', 250)->nullable();
            $table->string('info_whatsapp', 250)->nullable();
            $table->string('info_pagina', 250)->nullable();
            $table->text('info_mapa')->nullable();
            $table->integer('info_ano_experiencia')->nullable();
            $table->string('info_latitud', 25)->nullable();
            $table->string('info_longitud', 25)->nullable();
            $table->string('info_direccion', 250)->nullable();
            $table->dateTime('info_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('info_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_empresa');
    }
};
