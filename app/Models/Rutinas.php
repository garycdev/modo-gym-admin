<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutinas extends Model
{
    use HasFactory;

    protected $table = 'rutinas';
    protected $primaryKey = 'rut_id';
    protected $fillable = [
        'rut_id', 'usu_id', 'rut_grupo', 'ejer_id', 'rut_serie', 'rut_repeticiones', 'rut_peso',
        'rut_rid', 'rut_tiempo', 'rut_dia', 'rut_date_ini', 'rut_date_fin',
        'rut_estado', 'created_at', 'updated_at',
    ];
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usu_id');
    }
    public function ejercicio()
    {
        return $this->belongsTo(Ejercicios::class, 'ejer_id', 'ejer_id');
    }
}
