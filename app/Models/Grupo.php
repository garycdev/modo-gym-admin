<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table      = 'rgrupo';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'titulo',
        'estado',
        'usu_login_id',
        'created_at', 'updated_at',
    ];
}
