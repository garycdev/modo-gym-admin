<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTest extends Model
{
    use HasFactory;

    protected $table = 'tipo_test';
    protected $primaryKey = 'tipo_test_id';
    protected $fillable = [
        'tipo_test_id', 'tipo_test_titulo', 'tipo_test_ejercicio',
        'tipo_test_nombre', 'tipo_test_created_at',
        'tipo_test_updated_at'
    ];
}
