<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'pago_id';
    protected $fillable = [
        'pago_id', 'usu_id', 'pago_monto', 'costo_id', 'pago_fecha', 'pago_metodo',
        'pago_estado', 'pago_observaciones', 'creado_en', 'actualizado_en',
    ];
    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'actualizado_en';

    const CREATED_AT = 'creado_en';

    // Relacion con la tabla de usuarios
    public function cliente()
    {
        return $this->belongsTo(Usuarios::class, 'usu_id');
    }

    // Relacion con la tabla de costos
    public function costo()
    {
        return $this->belongsTo(Costos::class, 'costo_id');
    }

    // Scopes para obtener pagos por costo

    // Scope para mes actual respecto al costo
    public function scopeMesActual(Builder $query)
    {
        $hoy = Carbon::now()->startOfDay();
        // Validar el 10 de cada mes para el mes actual (si es el 10, se toma el mes actual)
        if ($hoy->day < 10) {
            // Inicio del mes anterior (si es el 10, se toma el mes anterior)
            $startDate = Carbon::now()->subMonth()->day(10)->startOfDay();
            $endDate = $hoy;
        } else {
            // Mes actual
            $startDate = Carbon::now()->day(10)->startOfDay();
            $endDate = $hoy;
        }

        return $query->whereBetween('creado_en', [$startDate, $endDate]);
    }

    // Scope para mes anterior respecto al costo
    public function scopeMesAnterior(Builder $query)
    {
        $hoy = Carbon::now()->startOfDay();
        // Validar el 10 de cada mes para el mes anterior (si es el 10, se toma el mes anterior)
        if ($hoy->day < 10) {
            // Inicio del mes anterior (si es el 10, se toma el mes anterior)
            $startDate = Carbon::now()->subMonths(2)->day(10)->startOfDay();
            $endDate = Carbon::now()->subMonth()->day(9)->endOfDay();
        } else {
            // Mes anterior
            $startDate = Carbon::now()->subMonth()->day(10)->startOfDay();
            $endDate = Carbon::now()->day(9)->endOfDay();
        }

        return $query->whereBetween('creado_en', [$startDate, $endDate]);
    }

}
