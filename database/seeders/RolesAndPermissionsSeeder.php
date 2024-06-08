<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::create(['name' => 'manage dashboard']));
        
        // Add other roles and permissions as needed
    }
}
