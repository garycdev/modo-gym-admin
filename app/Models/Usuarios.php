<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'usu_id';
    protected $fillable = [
        'usu_id',
        'usu_nombre',
        'usu_apellidos',
        'usu_ci',
        'usu_celular',
        'usu_huella',
        'usu_edad',
        'usu_genero',
        'usu_imagen',
        'usu_nivel',
        'usu_ante_medicos',
        'usu_lesiones',
        'usu_objetivo',
        'usu_frecuencia',
        'usu_hora',
        'usu_deportes',
        'usu_estado',
        'created_at',
        'updated_at',
    ];
    // public function validos()
    // {
    //     return $this->belongsToMany()
    // }

    public function costo()
    {
        return $this->belongsToMany(Costos::class, 'pagos', 'usu_id', 'costo_id')->limit(1);
    }

    public static function validarSesion($usu_ci, $password)
    {
        // Buscar el usuario por usu_ci
        $usuario = self::where('usu_ci', $usu_ci)->first();

        if ($usuario) {
            // Obtener el primer nombre y convertirlo en mayúsculas
            $primerNombre = strtoupper(explode(' ', $usuario->usu_nombre)[0]);

            // Crear la contraseña en el formato NOMBRE_USU_CI
            $passwordEsperado = $primerNombre . '_' . $usu_ci;

            // Validar si el password coincide
            if ($passwordEsperado === $password) {
                return $usuario; // Retorna el usuario si coincide
            }
        }

        return null; // Retorna null si no coincide
    }

    public function formulario()
    {
        return $this->hasOne(Formulario::class, 'usu_id', 'usu_id');
    }

    public function asistencias($dias)
    {
        return $this->hasMany(Asistencia::class, 'usu_id', 'usu_id')
            ->where('asistencia.asistencia_tipo', 'ENTRADA')
            // where between en un rango de la fecha actual menos el parametro dias [fecha-dias, fecha]
            ->whereBetween('asistencia.asistencia_fecha', [Carbon::now()->subDays($dias)->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
            ->orderBy('asistencia.asistencia_fecha', 'asc')
            ->get();
    }
}
