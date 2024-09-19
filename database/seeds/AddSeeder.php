<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            'user.create',
            'user.view',
            'user.edit',
            'user.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'admin',   // Guard name "admin"
                'group_name' => 'user',    // Group name "user"
            ]);
        }
    }
}
