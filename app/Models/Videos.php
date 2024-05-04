<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;


    protected $table = 'videos';
    protected $primaryKey = 'video_id';
    protected $fillable = [
        'video_id', 'video_titulo', 'video_descripcion','video_url',
        'video_created_at', 'video_updated_at'
    ];
}
