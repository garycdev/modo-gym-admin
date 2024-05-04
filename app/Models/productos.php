<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'producto_id';
    protected $fillable = [
        'producto_id', 'producto_nombre', 'producto_imagen', 'producto_precio',
        'producto_cantidad', 'producto_estado',
        'producto_created_at', 'producto_updated_at'
    ];

    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'producto_updated_at';
    const CREATED_AT = 'producto_created_at';
}
