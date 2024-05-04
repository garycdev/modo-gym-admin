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
}
