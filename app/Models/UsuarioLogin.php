<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class UsuarioLogin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'user';

    protected $table = 'usuario_login';
    protected $primaryKey = 'usu_login_id';
    protected $fillable = [
        'usu_login_name', 'usu_login_email', 'usu_login_username', 'usu_login_password',
    ];

    protected $hidden = [
        'usu_login_password', 'remember_token',
    ];
    // Especifica el nombre de la columna para updated_at
    const UPDATED_AT = 'usu_login_updated_at';

    const CREATED_AT = 'usu_login_created_at';

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')
            ->get();
        return $permission_groups;
    }

    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }
}
