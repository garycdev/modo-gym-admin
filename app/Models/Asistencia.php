<?php

namespace App\Models;
namespace App\Models\Usuarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencia';
    protected $primaryKey = 'asistencia_id';
    protected $fillable = [
        'asistencia_id',
        'usu_id',
        'asistencia_fecha',
        'asistencia_hora',
        'asistencia_tipo'
    ];

     // Relación con el modelo Usuario (asumiendo que 'usu_id' es la clave foránea)
     public function usuario()
     {
         return $this->belongsTo(Usuarios::class, 'usu_id', 'usu_id');
     }

     // Método para obtener el estado de asistencia en forma legible
    public function estadoAsistencia()
    {
        return $this->asistencia_asistio ? 1 : 0;
    }

    // Definición de un Accessor para obtener la fecha de asistencia en un formato específico
    public function getAsistenciaFechaAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    // Definición de un Mutator para establecer la fecha de asistencia en el formato adecuado
    public function setAsistenciaFechaAttribute($value)
    {
        $this->attributes['asistencia_fecha'] = date('Y-m-d', strtotime($value));
    }

}
