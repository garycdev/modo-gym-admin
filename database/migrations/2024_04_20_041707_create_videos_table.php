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
        Schema::create('videos', function (Blueprint $table) {
            $table->id('video_id');
            $table->string('video_titulo', 100)->notNullable();
            $table->text('video_descripcion')->nullable();
            $table->string('video_url', 255)->notNullable();
            $table->dateTime('video_created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('video_updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
