<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'usu_id';
    protected $fillable = [
        'usu_id', 'usu_nombre', 'usu_apellidos', 'usu_ci', 'usu_huella', 'usu_edad', 'usu_genero',
        'usu_imagen', 'usu_nivel', 'usu_ante_medicos', 'usu_lesiones', 'usu_objetivo',
        'usu_frecuencia', 'usu_hora', 'usu_deportes', 'usu_estado', 'created_at',
        'updated_at',
    ];
    // public function validos()
    // {
    //     return $this->belongsToMany()
    // }
}
