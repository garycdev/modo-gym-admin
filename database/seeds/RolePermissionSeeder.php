<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Enable these options if you need same role and other permission for User Model
         * Else, please follow the below steps for admin guard
         */

        // Create Roles and Permissions
        // $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        // $roleAdmin = Role::create(['name' => 'admin']);
        // $roleEditor = Role::create(['name' => 'editor']);
        // $roleUser = Role::create(['name' => 'user']);


        // Permission List as array
        $permissions = [

            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
            [
                'group_name' => 'blog',
                'permissions' => [
                    // Blog Permissions
                    'blog.create',
                    'blog.view',
                    'blog.edit',
                    'blog.delete',
                ]
            ],
            [
                'group_name' => 'admin',
                'permissions' => [
                    // admin Permissions
                    'admin.create',
                    'admin.view',
                    'admin.edit',
                    'admin.delete',
                    'admin.approve',
                ]
            ],
            [
                'group_name' => 'role',
                'permissions' => [
                    // role Permissions
                    'role.create',
                    'role.view',
                    'role.edit',
                    'role.delete',
                    'role.approve',
                ]
            ],
            [
                'group_name' => 'perfil',
                'permissions' => [
                    // profile Permissions
                    'perfil.view',
                    'perfil.edit',
                    'perfil.update',
                ]
            ],
            [
                'group_name' => 'cliente',
                'permissions' => [
                    // profile Permissions
                    'cliente.view',
                    'cliente.edit',
                    'cliente.delete',
                    'cliente.update',
                ]
            ],
            [
                'group_name' => 'asistencia',
                'permissions' => [
                    // Asistencia Permissions
                    'asistencia.create',
                    'asistencia.view',
                    'asistencia.edit',
                    'asistencia.delete',
                ]
            ],
            [
                'group_name' => 'cita',
                'permissions' => [
                    // Citas Permissions
                    'cita.create',
                    'cita.view',
                    'cita.edit',
                    'cita.delete',
                ]
            ],
            [
                'group_name' => 'contactar',
                'permissions' => [
                    // Contactar Permissions
                    'contactar.view',
                    'contactar.delete',
                ]
            ],
            [
                'group_name' => 'costo',
                'permissions' => [
                    // Costos Permissions
                    'costo.view',
                    'costo.edit',
                ]
            ],
            [
                'group_name' => 'ejercicio',
                'permissions' => [
                    // Ejercicios Permissions
                    'ejercicio.create',
                    'ejercicio.view',
                    'ejercicio.edit',
                    'ejercicio.delete',
                ]
            ],
            [
                'group_name' => 'equipo',
                'permissions' => [
                    // Equipo Permissions
                    'equipo.create',
                    'equipo.view',
                    'equipo.edit',
                    'equipo.delete',
                ]
            ],
            [
                'group_name' => 'galeria',
                'permissions' => [
                    // Ejercicios Permissions
                    'galeria.create',
                    'galeria.view',
                    'galeria.edit',
                    'galeria.delete',
                ]
            ],
            [
                'group_name' => 'horario',
                'permissions' => [
                    // Horarios Permissions
                    'horario.create',
                    'horario.view',
                    'horario.edit',
                    'horario.delete',
                ]
            ],
            [
                'group_name' => 'imagen_galeria',
                'permissions' => [
                    // Imagenes Galerias Permissions
                    'imagen_galeria.create',
                    'imagen_galeria.view',
                    'imagen_galeria.edit',
                    'imagen_galeria.delete',
                ]
            ],
            [
                'group_name' => 'informacion_empresa',
                'permissions' => [
                    // Informacion Empresa Permissions
                    'informacion_empresa.view',
                    'informacion_empresa.edit',
                ]
            ],
            [
                'group_name' => 'medida',
                'permissions' => [
                    // Medidas Permissions
                    'medida.create',
                    'medida.view',
                    'medida.edit',
                    'medida.delete',
                ]
            ],
            [
                'group_name' => 'musculo',
                'permissions' => [
                    // Musculos Permissions
                    'musculo.create',
                    'musculo.view',
                    'musculo.edit',
                    'musculo.delete',
                ]
            ],
            [
                'group_name' => 'pago',
                'permissions' => [
                    // Pagos Permissions
                    'pago.create',
                    'pago.view',
                    'pago.edit',
                    'pago.delete',
                ]
            ],
            [
                'group_name' => 'producto',
                'permissions' => [
                    // Producto Permissions
                    'producto.create',
                    'producto.view',
                    'producto.edit',
                    'producto.delete',
                ]
            ],
            [
                'group_name' => 'rutina',
                'permissions' => [
                    // Producto Permissions
                    'rutina.create',
                    'rutina.view',
                    'rutina.edit',
                    'rutina.delete',
                ]
            ],
            [
                'group_name' => 'test_seguimiento',
                'permissions' => [
                    // Test Seguimiento Permissions
                    'test_seguimiento.create',
                    'test_seguimiento.view',
                    'test_seguimiento.edit',
                    'test_seguimiento.delete',
                ]
            ],
            [
                'group_name' => 'tipo_medida',
                'permissions' => [
                    // Tipo Medidas Permissions
                    'tipo_medida.create',
                    'tipo_medida.view',
                    'tipo_medida.edit',
                    'tipo_medida.delete',
                ]
            ],
            [
                'group_name' => 'tipo_test',
                'permissions' => [
                    // Tipo Test Permissions
                    'tipo_test.create',
                    'tipo_test.view',
                    'tipo_test.edit',
                    'tipo_test.delete',
                ]
            ],
            [
                'group_name' => 'video',
                'permissions' => [
                    // Video Permissions
                    'video.create',
                    'video.view',
                    'video.edit',
                    'video.delete',
                ]
            ],
        ];

        // Create and Assign Permissions
        // for ($i = 0; $i < count($permissions); $i++) {
        //     $permissionGroup = $permissions[$i]['group_name'];
        //     for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
        //         // Create Permission
        //         $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
        //         $roleSuperAdmin->givePermissionTo($permission);
        //         $permission->assignRole($roleSuperAdmin);
        //     }
        // }

        // Do same for the admin guard for tutorial purposes.
        $admin = Admin::where('username', 'superadmin')->first();
        $roleSuperAdmin = $this->maybeCreateSuperAdminRole($admin);

        // Create and Assign Permissions
        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                $permissionExist = Permission::where('name', $permissions[$i]['permissions'][$j])->first();
                if (is_null($permissionExist)) {
                    $permission = Permission::create(
                        [
                            'name' => $permissions[$i]['permissions'][$j],
                            'group_name' => $permissionGroup,
                            'guard_name' => 'admin'
                        ]
                    );
                    $roleSuperAdmin->givePermissionTo($permission);
                    $permission->assignRole($roleSuperAdmin);
                }
            }
        }

        // Assign super admin role permission to superadmin user
        if ($admin) {
            $admin->assignRole($roleSuperAdmin);
        }
    }

    private function maybeCreateSuperAdminRole($admin): Role
    {
        if (is_null($admin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        } else {
            $roleSuperAdmin = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        }

        if (is_null($roleSuperAdmin)) {
            $roleSuperAdmin = Role::create(['name' => 'superadmin', 'guard_name' => 'admin']);
        }

        return $roleSuperAdmin;
    }
}
