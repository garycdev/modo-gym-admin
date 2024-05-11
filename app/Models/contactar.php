<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactar extends Model
{
    use HasFactory;

    protected $table = 'contactar';
    protected $primaryKey = 'contactar_id';
    protected $fillable = [
        'contactar_id', 'contactar_nombre', 'contactar_correo', 'contactar_celular',
        'contactar_descripcion', 'contactar_created_at'
    ];
    // Especifica el nombre de la columna para updated_at
    const CREATED_AT = 'contactar_created_at';
}
