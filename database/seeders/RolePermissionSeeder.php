<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Get roles
        $superAdmin = Role::findByName('Super Admin');
        $admin = Role::findByName('Admin');
        $editor = Role::findByName('Editor');
        $author = Role::findByName('Author');

        // Super Admin gets everything
        $superAdmin->syncPermissions(Permission::all());

        // Admin permissions
        $admin->syncPermissions([
            'view dashboard',

            'view users',
            'create users',
            'edit users',

            'view contents',
            'create contents',
            'edit contents',
            'delete contents',
            'publish contents',

            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            'view tags',
            'create tags',
            'edit tags',
            'delete tags',

            'view media',
            'create media',
            'edit media',
            'upload media',
            'delete media',

            'view menus',
            'create menus',
            'edit menus',

            'manage settings',
        ]);

        // Editor permissions
        $editor->syncPermissions([
            'view dashboard',

            'view contents',
            'create contents',
            'edit contents',
            'publish contents',

            'view categories',

            'view tags',

            'view media',
            'upload media',
        ]);

        // Author permissions
        $author->syncPermissions([
            'view dashboard',

            'view contents',

            'create contents',

            'edit contents',
        ]);
    }
}
