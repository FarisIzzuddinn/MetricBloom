<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
            'Super Admin Dashboard',
            'Manage State',
            'Manage Institution',
            'view stateAdmin dashboard',
            'kpi management',
            'user state management',
            'view institutionAdmin dashboard',
            'kpi management institution',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superadminRole = Role::create(['name' => 'super admin']);
        $superadminRole->givePermissionTo([
            'view permissions',
            'view roles',
            'view users',
            'Super Admin Dashboard',
            'Manage State',
            'Manage Institution'
        ]);
        
        // Buat roles dan assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view dashboard',
            'view add kpi',
            'view so',
            'view teras',
        ]);


        $AdminState = Role::create(['name' => 'Admin State']);
        $AdminState->givePermissionTo([
            'view stateAdmin dashboard',
            'kpi management',
        ]);

        $InstitutionAdmin = Role::create(['name' => 'Institution Admin']);
        $InstitutionAdmin->givePermissionTo([
            'view institutionAdmin dashboard',
            'kpi management institution'
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

        $superadmin1 = User::updateOrCreate(
            ['email' => 'adminSuper@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('adminSuper@123'), 
            ]
        );

        $superadmin->assignRole($superadminRole);
        $superadmin1->assignRole($superadminRole);
       
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'), 
            ]
        );
        
        $admin1 = User::updateOrCreate(
            ['email' => 'adminBiasa@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('adminBiasa@123'),
            ]
        );
        
        $admin->assignRole($adminRole);
        $admin1->assignRole($adminRole);

        $user1 = User::updateOrCreate(
            ['email' => 'userBiasa@gmail.com'],
            [
                'name' => 'user',
                'password' => Hash::make('userBiasa@123'), 
            ]
        );

        $user1->assignRole($userRole);
    }
}
