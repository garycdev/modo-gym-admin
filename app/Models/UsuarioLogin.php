<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioLogin extends Model
{
    use HasFactory;



    protected $table = 'usuario_login';
    protected $primaryKey = 'usu_login_id';
    protected $fillable = [
        'usu_login_id', 'usu_login_usuario', 'usu_login_password','usu_id',
        'usu_login_created_at', 'usu_login_updated_at'
    ];
    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'usu_login_updated_at';

    const CREATED_AT = 'usu_login_created_at';
}
