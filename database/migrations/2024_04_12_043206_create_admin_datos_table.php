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
        Schema::create('admin_datos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->string('imagen', 250)->default('');
            $table->string('nombre', 250);
            $table->string('apellidos', 250)->default('');
            $table->string('celular', 250)->default('');
            $table->string('direccion', 250)->default('');
            $table->string('rol_persona', 250)->default('');
            $table->string('correo', 250);
            $table->string('pagina_web')->default('');
            $table->string('tiktok')->default('');
            $table->string('instagram')->default('');
            $table->string('twitter')->default('');
            $table->string('facebook')->default('');
            $table->string('github')->default('');
            $table->string('linkedin')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_datos');
    }
};
