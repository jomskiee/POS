<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
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

        // Create a sample broker user
        User::create([
            'name' => 'Broker User',
            'email' => 'broker@mail.com',
            'password' => Hash::make('12345678'),
            'role' => 'broker',
        ]);
    }
}
