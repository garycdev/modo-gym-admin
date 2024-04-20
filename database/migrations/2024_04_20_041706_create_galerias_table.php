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
        Schema::create('galerias', function (Blueprint $table) {
            $table->id('galeria_id');
            $table->string('galeria_nombre', 100)->notNullable();
            $table->text('galeria_descripcion')->nullable();
            $table->dateTime('galeria_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('galeria_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galerias');
    }
};
