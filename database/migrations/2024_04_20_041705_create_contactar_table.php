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
        Schema::create('contactar', function (Blueprint $table) {
            $table->id('contactar_id');
            $table->string('contactar_nombre', 250);
            $table->string('contactar_correo', 250);
            $table->string('contactar_celular', 250);
            $table->text('contactar_descripcion');
            $table->dateTime('contactar_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactar');
    }
};
