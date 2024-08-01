<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costos extends Model
{
    use HasFactory;

    protected $table = 'costos';
    protected $primaryKey = 'costo_id';
    protected $fillable = [
        'costo_id',
        'nombre',
        'tipo',
        'periodo',
        'monto',
        'mes',
        'ingreso_dia',
        'ingreso_semana',
        'created_at',
        'updated_at',
    ];

    public function pagosMesActual()
    {
        return $this->hasMany(Pagos::class, 'costo_id')->mesActual();
    }
    public function pagosMesAnterior()
    {
        return $this->hasMany(Pagos::class, 'costo_id')->mesAnterior();
    }
}
