<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutinaDefecto extends Model
{
    use HasFactory;

    protected $table = 'rutinas_defecto';
    protected $primaryKey = 'rd_id';
    protected $fillable = [
        'ejer_id',
        'rut_dia',
        'rut_serie',
        'rut_repeticiones',
        'rut_rid',
        'rut_tiempo',
        'rut_estado',
        'created_at',
        'updated_at',
    ];
    public function ejercicio()
    {
        return $this->belongsTo(Ejercicios::class, 'ejer_id', 'ejer_id');
    }
}
