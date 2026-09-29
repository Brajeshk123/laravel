<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            // Dashboard
            'view dashboard',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Roles
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permissions
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // Contents
            'view contents',
            'create contents',
            'edit contents',
            'delete contents',
            'publish contents',

            // Categories
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'restore categories',
            'force delete categories',

            // Tags
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',

            // Media
            'view media',
            'create media',
            'edit media',
            'upload media',
            'delete media',

            // Menus
            'view menus',
            'create menus',
            'edit menus',
            'delete menus',

            // Website Settings
            'manage settings',

            // Contact Messages
            'view contacts',
            'delete contacts',

            // Newsletter
            'view newsletter',
            'manage newsletter',

            // Activity Logs
            'view activity logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::where('name', 'Super Admin')
            ->where('guard_name', 'web')
            ->first();

        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
