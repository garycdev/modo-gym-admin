<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    use HasFactory;

    protected $table = 'horarios';
    protected $primaryKey = 'horario_id';
    protected $fillable = [
        'horario_id', 'admins_id', 'horario_fecha', 'horario_hora_inicio',
        'horario_hora_fin', 'horario_disponible'
    ];
}
