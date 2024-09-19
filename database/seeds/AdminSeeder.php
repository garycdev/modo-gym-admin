<?php

use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::where('username', 'superadmin')->first();

        if (is_null($admin)) {
            $adminId = DB::table('admins')->insertGetId([
                'name' => 'Juan Valencia',
                'email' => 'superadmin@gmail.com',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin'),
            ]);
        }else {
            $adminId = $admin->id;
        }
        // Crear el registro en admin_datos
        DB::table('admin_datos')->insert([
            'admin_id' => $adminId,
            'nombre' => 'Juan Valencia',
            'correo' => 'jpvalencia.developer@gmail.com',
            // Puedes establecer los otros campos a valores predeterminados aquí si es necesario
        ]);
    }
}
