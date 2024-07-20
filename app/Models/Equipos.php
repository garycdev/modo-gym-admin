<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
    use HasFactory;


    protected $table = 'equipos';
    protected $primaryKey = 'equi_id';
    protected $fillable = [
        'equi_id', 'equi_nombre', 'equi_imagen', 'peso', 'equi_estado',
        'created_at', 'updated_at'
    ];
}
