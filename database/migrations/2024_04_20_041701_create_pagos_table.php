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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('pago_id');
            $table->unsignedBigInteger('usu_id');
            $table->decimal('pago_monto', 10, 2);
            $table->unsignedBigInteger('costo_id');
            $table->date('pago_fecha');
            $table->enum('pago_metodo', ['EFECTIVO', 'TARJETA_CREDITO', 'TRANSFERENCIA', 'OTRO']);
            $table->enum('pago_estado', ['PENDIENTE', 'COMPLETADO', 'CANCELADO'])->default('PENDIENTE');
            $table->text('pago_observaciones')->nullable();
            $table->dateTime('creado_en')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('actualizado_en')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Definir las relaciones de clave foránea
            $table->foreign('usu_id')->references('usu_id')->on('usuarios');
            $table->foreign('costo_id')->references('costo_id')->on('costos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
