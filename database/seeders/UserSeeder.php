<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'user_nama' => 'Admin',
            'user_username' => 'admin',
            'user_password' => Hash::make('12345'), // 🔥 WAJIB HASH
            'user_role' => 'admin'
        ]);

        User::create([
            'user_nama' => 'Kasir',
            'user_username' => 'kasir',
            'user_password' => Hash::make('12345'),
            'user_role' => 'kasir'
        ]);
    }
}