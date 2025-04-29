<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'planes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'periodo',
        'monto',
        'promo',
        'promo_fin',
        'descripcion',
        'estado'
    ];
}
