<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'telepon' => '0895701175432',
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'Owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('owner123'),
            'telepon' => '0895701175433',
            'role' => 'owner',
        ]);
    }
}
