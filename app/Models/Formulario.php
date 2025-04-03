<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'formularios';
    protected $primaryKey = 'id_formulario';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'inscrito',
        'nombre_completo',
        'fecha_nacimiento',
        'edad',
        'telefono',
        'direccion',
        'correo',
        'medicamentos',
        'enfermedades',
        'referencia',
        'entrenamiento',
        'horario',
        'dias_semana',
        'nivel_entrenamiento',
        'lesion',
        'objetivos',
        'deportes_detalles',
        'usu_id'
    ];

    // El campo 'objetivos' es un campo JSON
    protected $casts = [
        'objetivos' => 'array', // Para que Laravel lo maneje como un array
    ];

    // Relación con el modelo Usuario (un formulario pertenece a un usuario)
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usu_id', 'usu_id');
    }
}
