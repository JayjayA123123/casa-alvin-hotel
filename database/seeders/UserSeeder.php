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
            'name' => 'Alvin Jay Cornejo',
            'email' => 'alvin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
