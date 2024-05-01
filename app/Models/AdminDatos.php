<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminDatos extends Model
{
    use HasFactory;

    protected $table = 'admin_datos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'admin_id', 'imagen', 'nombre', 'apellidos', 'celular', 'direccion', 'rol_persona', 'correo', 'pagina_web', 'tiktok', 'instagram', 'twitter', 'facebook', 'github', 'linkedin'
    ];
}
