<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medidas extends Model
{
    use HasFactory;

    // protected $table = 'medidas';
    // protected $primaryKey = 'med_id';
    // protected $fillable = [
    //     'med_id', 'info_nombre', 'tipo_med_id', 'med_peso',
    //     'usu_id', 'created_at', 'updated_at'
    // ];
    protected $table      = 'medidas';
    protected $primaryKey = 'med_id';
    protected $fillable   = [
        'usu_id',
        'peso',
        'talla',
        'imc',
        'grasa',
        'icc',
        'rcv',
        'peso_ideal',
        'xmes',
        'tiempo_estimado',
        'med_estado',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuarios::class, 'usu_id', 'usu_id');
    }

    public function detalles()
    {
        return $this->hasMany(MedidasDetalle::class, 'med_id');
    }
}
