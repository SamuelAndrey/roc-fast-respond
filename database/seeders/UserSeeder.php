<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::query()->create([
            'name' => 'Samuel Admin',
            'username' => 'samueladmin',
            'email' => 'samueladmin@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'admin',
        ]);


        User::query()->create([
            'name' => 'Samuel Agent',
            'username' => 'samuelagent',
            'email' => 'samuelagent@gmail.com',
            'password' => Hash::make('user123'),
            'role' => 'agent',
        ]);
    }
}
