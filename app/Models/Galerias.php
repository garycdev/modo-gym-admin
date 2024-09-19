<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galerias extends Model
{
    use HasFactory;

    protected $table = 'galerias';
    protected $primaryKey = 'galeria_id';
    protected $fillable = [
        'galeria_id', 'galeria_nombre', 'galeria_descripcion',
        'galeria_created_at', 'galeria_updated_at',
    ];
    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'galeria_updated_at';

    const CREATED_AT = 'galeria_created_at';

    public function imagenes()
    {
        return $this->hasMany(ImagenesGalerias::class, 'galeria_id', 'galeria_id'); // Relación uno a muchos
    }
}
