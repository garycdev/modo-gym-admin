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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('blog_id');
            $table->string('blog_titulo', 250);
            $table->string('blog_imagen', 250)->nullable();
            $table->text('blog_descripcion')->nullable();
            $table->enum('blog_estado', ['ACTIVO', 'INACTIVO', 'DESACTIVADO', 'ELIMINADO'])->default('ACTIVO');
            $table->dateTime('blog_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('blog_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
