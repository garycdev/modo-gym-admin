<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;


    protected $table = 'pagos';
    protected $primaryKey = 'pago_id';
    protected $fillable = [
        'pago_id', 'usu_id', 'pago_monto', 'costo_id', 'pago_fecha', 'pago_metodo',
        'pago_estado', 'pago_observaciones', 'creado_en', 'actualizado_en'
    ];
}
