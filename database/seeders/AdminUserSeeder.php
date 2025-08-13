<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Create a sample employee user
        User::create([
            'name' => 'Employee User',
            'email' => 'employee@mail.com',
            'password' => Hash::make('12345678'),
            'role' => 'employee',
        ]);
    }
}
