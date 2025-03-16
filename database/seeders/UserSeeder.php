<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 users
        $users = [
            [
                'name' => 'Ahmed',
                'email' => 'Ahmed@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Osama',
                'email' => 'Osama@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Mostafa',
                'email' => 'Mostafa@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Mohamed',
                'email' => 'Mohamed@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Hashem',
                'email' => 'Hashem@example.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
           User::create($userData);
        }

    }
}
