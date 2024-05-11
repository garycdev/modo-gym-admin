<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenesGalerias extends Model
{
    use HasFactory;

    protected $table = 'imagenes_galerias';
    protected $primaryKey = 'imagen_id';
    protected $fillable = [
        'imagen_id', 'galeria_id', 'imagen_url', 'imagen_created_at',
        'imagen_updated_at'
    ];
    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'imagen_updated_at';
    const CREATED_AT = 'imagen_created_at';
}
