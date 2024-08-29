<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions
        $permissions = [
            'view permissions',
            'view roles',
            'view users',
            'view dashboard',
            'view add kpi',
            'view user dashboard',
            'view so',
            'view teras',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Buat roles dan assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view dashboard',
            'view add kpi',
            'view so',
            'view teras',
        ]);

        $superadminRole = Role::create(['name' => 'super admin']);
        $superadminRole->givePermissionTo([
            'view permissions',
            'view roles',
            'view users'
        ]);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view user dashboard',
        ]);

        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), 
            ]
        );

        $superadmin->assignRole($superadminRole);
       
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'), // Use a secure password
            ]
        );

        $admin->assignRole($adminRole);

        // Generate 100 users
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('87654321'),
            ]);

            // Assign roles randomly
            if ($i < 10) {
                $user->assignRole($superadminRole);
            } elseif ($i < 40) {
                $user->assignRole($adminRole);
            } else {
                $user->assignRole($userRole);
            }
        }

        
    }
}
