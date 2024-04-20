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
        Schema::create('imagenes_galerias', function (Blueprint $table) {
            $table->id('imagen_id');
            $table->unsignedBigInteger('galeria_id');
            $table->string('imagen_url', 255)->notNullable();
            $table->dateTime('imagen_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('imagen_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Definir la relación de clave foránea
            $table->foreign('galeria_id')->references('galeria_id')->on('galerias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes_galerias');
    }
};
