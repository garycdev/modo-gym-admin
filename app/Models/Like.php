<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table      = 'likes';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'usu_login_id',
        'blog_id'
    ];
}
