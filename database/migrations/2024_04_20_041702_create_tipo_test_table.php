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
        Schema::create('tipo_test', function (Blueprint $table) {
            $table->id('tipo_test_id');
            $table->enum('tipo_test_titulo', ['MEDIDAS DE 1RM', 'FLEXIBILIDAD', 'REPETICIONES MAXIMAS']);
            $table->enum('tipo_test_ejercicio', ['PIERNAS', 'TORSOS']);
            $table->string('tipo_test_nombre', 100);
            $table->dateTime('tipo_test_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('tipo_test_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_test');
    }
};
