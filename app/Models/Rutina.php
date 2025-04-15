<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    use HasFactory;

    protected $table      = 'rutina';
    protected $primaryKey = 'rut_id';
    protected $fillable   = [
        'rut_id', 'usu_id', 'ejer_id', 'rut_serie', 'rut_repeticiones', 'rut_peso',
        'rut_rid', 'rut_tiempo',
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
