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
        Schema::create('usuario_login', function (Blueprint $table) {
            $table->bigIncrements('usu_login_id');
            $table->string('usu_login_usuario', 250)->nullable(false);
            $table->string('usu_login_password', 250)->unique()->nullable(false);
            $table->unsignedBigInteger('usu_id');
            $table->dateTime('usu_login_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('usu_login_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Definir la relación de clave foránea
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_login');
    }
};
