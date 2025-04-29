<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogRutina extends Model
{
    use HasFactory;

    protected $table      = 'blogs_rutina';
    protected $primaryKey = 'bg_id';
    protected $fillable   = [
        'blog_id',
        'ejer_id',
        'rut_id',
        'series',
        'peso',
        'repeticiones',
    ];

    public function ejercicios()
    {
        return $this->belongsTo(Ejercicios::class, 'ejer_id', 'ejer_id');
    }
}
