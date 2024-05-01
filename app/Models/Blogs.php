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
        'blog_estado', 'blog_created_at', 'blog_created_at'
    ];
}
