<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'John Mwangi',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Sylvia Munyao',
            'email' => 'sly@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);
    }
}