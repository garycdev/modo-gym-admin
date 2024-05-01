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
        'created_at', 'updated_at'
    ];
}
