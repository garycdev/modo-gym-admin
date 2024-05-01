<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMedidas extends Model
{
    use HasFactory;

    protected $table = 'tipo_medidas';
    protected $primaryKey = 'tipo_med_id';
    protected $fillable = [
        'tipo_med_id', 'tipo_med_nombre', 'tipo_med_estado',
        'created_at', 'updated_at'
    ];
}
