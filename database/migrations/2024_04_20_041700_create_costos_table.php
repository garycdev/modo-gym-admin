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
        Schema::create('costos', function (Blueprint $table) {
            $table->id('costo_id');
            $table->enum('periodo', ['MENSUAL', 'ANUAL', 'SEMESTRAL', 'PRODUCTO']);
            $table->decimal('monto', 10, 2);

            // Se agregan las marcas de tiempo por defecto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costos');
    }
};
