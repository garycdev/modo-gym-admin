<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $table = 'citas';
    protected $primaryKey = 'cita_id';
    protected $fillable = [
        'cita_id', 'admins_id', 'usu_id', 'citas_fecha',
        'citas_hora_inicio', 'citas_hora_fin'
    ];
}
