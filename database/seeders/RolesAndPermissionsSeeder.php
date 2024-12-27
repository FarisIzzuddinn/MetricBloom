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
            'generate report',
            'view sector dashboard'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superadminRole = Role::create(['name' => 'super admin']);
        $superadminRole->givePermissionTo([
            'view users',
            'view teras',
            'view so',
            'view add kpi',
            'Super Admin Dashboard',
            'generate report',
            'Manage Institution'
        ]);

        $bahagianAdmin = Role::create(['name' => 'Admin Bahagian']);
        $bahagianAdmin->givePermissionTo([
            'view dashboard',
            'view admin bahagian KPI',
        ]);
        
        $sectorAdmin = Role::create(['name' => 'Admin Sector']);
        $sectorAdmin->givePermissionTo([
            'view add kpi',
            'view sector dashboard'
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
    }
}
