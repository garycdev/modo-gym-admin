<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformacionEmpresa extends Model
{
    use HasFactory;

    protected $table = 'informacion_empresa';
    protected $primaryKey = 'informacion_id';
    protected $fillable = [
        'informacion_id', 'info_nombre', 'info_logo', 'info_descripcion', 'info_sobre_nosotros',
        'info_video_url', 'info_telefono_1', 'info_contacto_1', 'info_contacto_2',
        'info_contacto_3', 'info_atencion', 'info_correo', 'info_facebook', 'info_tiktok',
        'info_whatsapp', 'info_pagina', 'info_mapa', 'info_ano_experiencia', 'info_latitud',
        'info_longitud', 'info_direccion', 'info_created_at', 'info_updated_at'
    ];

    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'info_updated_at';

    const CREATED_AT = 'info_created_at';
}
