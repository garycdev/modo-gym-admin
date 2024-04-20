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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('producto_id');
            $table->string('producto_nombre', 250)->nullable();
            $table->string('producto_imagen', 250)->nullable();
            $table->double('producto_precio', 4, 2);
            $table->integer('producto_cantidad')->nullable();
            $table->enum('producto_estado', ['ACTIVO', 'INACTIVO', 'DESACTIVADO', 'ELIMINADO'])->default('ACTIVO');
            $table->dateTime('producto_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('producto_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
