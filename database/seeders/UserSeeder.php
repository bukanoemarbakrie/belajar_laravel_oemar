<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User Admin
        User::updateOrCreate(
            ['email' => 'admin1@gmail.com'], // Patokan pencarian data
            [
                'name'     => 'Admin',
                'password' => Hash::make('12345678'),
                'role_id'  => 1,
            ]
        );

        // 2. User Cashier
        User::updateOrCreate(
            ['email' => 'cashier@gmail.com'],
            [
                'name'     => 'Cashier',
                'password' => Hash::make('12345678'),
                'role_id'  => 2,
            ]
        );

        // 3. User Manager
        User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name'     => 'Manager',
                'password' => Hash::make('12345678'),
                'role_id'  => 3,
            ]
        );
    }
}
