<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $primaryKey = 'blog_id';
    protected $fillable = [
        'blog_id', 'blog_titulo', 'blog_imagen', 'blog_descripcion',
        'blog_estado', 'blog_created_at', 'blog_updated_at'
    ];
    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'blog_updated_at';
    const CREATED_AT = 'blog_created_at';
}
