<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::where('slug','super_admin')->first();
        if($superAdminRole){
            User::firstOrCreate(
                ['email' => 'superadmin@example.com'],
                [
                    'name' => 'Platform Super Admin',
                    'email' => 'superadmin@example.com',
                    'password' => Hash::make('password'),
                    'role_id' => $superAdminRole->id,
                    'status' => true,
                ]
            );

        }
    }
}
