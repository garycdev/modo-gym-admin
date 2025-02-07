<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSeguimientos extends Model
{
    use HasFactory;

    protected $table = 'test_seguimientos';
    protected $primaryKey = 'test_id';
    protected $fillable = [
        'test_id', 'tipo_test_id', 'test_fecha', 'test_dato', 'usu_id',
        'test_created_at', 'test_updated_at'
    ];
    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'test_updated_at';

    const CREATED_AT = 'test_created_at';
}
