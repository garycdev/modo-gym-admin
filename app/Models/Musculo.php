<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musculo extends Model
{
    use HasFactory;



    protected $table = 'musculo';
    protected $primaryKey = 'mus_id';
    protected $fillable = [
        'mus_id', 'mus_nombre', 'mus_imagen', 'mus_estado',
        'created_at', 'updated_at'
    ];
}
