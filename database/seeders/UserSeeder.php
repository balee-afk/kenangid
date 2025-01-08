<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'usertype' => 'superadmin',
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'usertype' => 'admin',
        ]);

        // User
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'usertype' => 'user',
        ]);
    }
}
