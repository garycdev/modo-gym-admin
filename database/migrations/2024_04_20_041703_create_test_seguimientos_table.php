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
        Schema::create('test_seguimientos', function (Blueprint $table) {
            $table->id('test_id');
            $table->unsignedBigInteger('tipo_test_id');
            $table->date('test_fecha');
            $table->text('test_dato');
            $table->unsignedBigInteger('usu_id');
            $table->dateTime('test_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('test_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Definir las relaciones de clave foránea
            $table->foreign('tipo_test_id')->references('tipo_test_id')->on('tipo_test');
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_seguimientos');
    }
};
