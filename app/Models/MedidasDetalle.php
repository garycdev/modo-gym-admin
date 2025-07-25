<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedidasDetalle extends Model
{
    use HasFactory;

    // protected $table = 'medidas';
    // protected $primaryKey = 'med_id';
    // protected $fillable = [
    //     'med_id', 'info_nombre', 'tipo_med_id', 'med_peso',
    //     'usu_id', 'created_at', 'updated_at'
    // ];
    protected $table      = 'medidas_detalle';
    protected $primaryKey = 'med_det_id';
    protected $fillable   = [
        'med_id',
        'brazo',
        'antebrazo',
        'torso',
        'cintura_es',
        'cintura_om',
        'cadera',
        'muslo',
        'pierna',
        'pcb',
        'ptc',
        'pse',
        'psi',
        'med_det_estado',
        'created_at',
        'updated_at',
    ];
}
