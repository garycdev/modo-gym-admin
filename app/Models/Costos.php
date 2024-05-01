<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costos extends Model
{
    use HasFactory;

    protected $table = 'costos';
    protected $primaryKey = 'costo_id';
    protected $fillable = [
        'costo_id', 'periodo', 'monto', 'created_at',
        'updated_at'
    ];
}
