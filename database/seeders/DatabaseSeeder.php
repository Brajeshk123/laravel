<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            CategorySeeder::class,
        ]);

        $user = \App\Models\User::first();

        if ($user && !$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
        }
    }
}
