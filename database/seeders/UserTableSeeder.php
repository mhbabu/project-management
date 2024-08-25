<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate([
            'name'     => 'Admin User',
            'email'    => 'admin@gmail.com',
            'type'     => 'Admin',
            'password' => Hash::make('password'),
        ]);

        // Create team leader user
        User::firstOrCreate([
            'name'     => 'Team Leader User',
            'email'    => 'teamleader@gmail.com',
            'type'     => 'team-leader',
            'password' => Hash::make('password'),
        ]);

        // Create developer user
        User::firstOrCreate([
            'name'     => 'Developer User',
            'email'    => 'developer@gmail.com',
            // 'type'     => 'developer',
            'password' => Hash::make('password')
        ]);
    }
}
