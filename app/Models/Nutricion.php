<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutricion extends Model
{
    use HasFactory;

    protected $table      = 'nutricion';
    protected $primaryKey = 'nut_id';
    protected $fillable   = [
        'usu_id',
        'nombre',
        'edad',
        'fecha',
        'antecedentes_medicos_familiares',
        'hijos',
        'ciclo_menstrual',
        'medicamentos',
        'objetivo',
        'intolerancias_alergias',
        'habito',
        'alcohol',
        'tabaco',
        'actividad_fisica',
        'nut_estado',
    ];
}
