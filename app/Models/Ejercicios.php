<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicios extends Model
{
    use HasFactory;

    protected $table = 'ejercicios';
    protected $primaryKey = 'ejer_id';
    protected $fillable = [
        'ejer_id', 'ejer_nombre', 'ejer_imagen', 'ejer_descripcion',
        'ejer_nivel', 'equi_id', 'mus_id', 'ejer_estado',
        'created_at', 'updated_at',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipos::class, 'equi_id');
    }

    public function musculo()
    {
        return $this->belongsTo(Musculo::class, 'mus_id');
    }
}
