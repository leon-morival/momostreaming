<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Find the user you want to assign the admin role to
        $user = User::where('email', 'leon.morival@gmail.com')->first();

        // Ensure the user exists
        if ($user) {
            // Create the admin role if it doesn't exist
            $adminRole = Role::firstOrCreate(['name' => 'admin']);

            // Assign the role to the user
            $user->assignRole($adminRole);
        }
    }
}
