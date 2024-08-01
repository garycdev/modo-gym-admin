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

    public function cliente()
    {
        return $this->belongsTo(Usuarios::class, 'usu_id');
    }
    public function costo()
    {
        return $this->belongsTo(Costos::class, 'costo_id');
    }

    public function scopeMesActual(Builder $query)
    {
        $startDate = Carbon::now()->copy()->day(10)->startOfDay();
        $endDate = Carbon::now()->copy()->addMonth()->day(9)->endOfDay();

        return $query->whereBetween('pago_fecha', [$startDate, $endDate]);
    }
    public function scopeMesAnterior(Builder $query)
    {
        $startDate = Carbon::now()->startOfMonth()->subMonth()->day(10)->startOfDay();
        $endDate = Carbon::now()->day(9)->endOfDay();

        return $query->whereBetween('pago_fecha', [$startDate, $endDate]);
    }
}
