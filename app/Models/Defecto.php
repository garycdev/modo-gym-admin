<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defecto extends Model
{
    use HasFactory;

    protected $table = 'defecto';
    protected $primaryKey = 'def_id';
    protected $fillable = [
        'def_nombre',
        'def_estado',
        'created_at',
        'updated_at',
    ];
}
