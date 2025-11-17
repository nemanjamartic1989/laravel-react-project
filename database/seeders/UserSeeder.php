<?php

namespace Database\Seeders;

use App\Constants\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(['name' => UserRole::SUPERADMIN]);
        Role::updateOrCreate(['name' => UserRole::ADMIN]);
        Role::updateOrCreate(['name' => UserRole::USER]);

        // Superadmin user
        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('SuperAdmin12!'),
                'email_verified_at' => now(),
            ]
        );
        $superadmin->assignRole(UserRole::SUPERADMIN);
        $superadmin->tokens()->delete();
        $superadmin->createToken('superadmin-token');

        // Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('AdminUser12!'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole(UserRole::ADMIN);
        $admin->tokens()->delete();
        $admin->createToken('admin-token');

        // Regular users
        User::factory()->count(10)->create()->each(function ($user) {
            $user->assignRole(UserRole::USER);
            $user->createToken('user-token');
        });
    }
}
