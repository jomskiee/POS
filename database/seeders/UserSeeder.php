<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Broker;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'address' => '123 Admin Street, Admin City, AC 12345',
            ],
            [
                'name' => 'Sarah Manager',
                'email' => 'sarah@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'address' => '456 Management Ave, Admin City, AC 12346',
            ],
            [
                'name' => 'John Broker',
                'email' => 'john.broker@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
                'address' => '789 Sales Street, Broker City, BC 54321',
            ],
            [
                'name' => 'Jane Sales',
                'email' => 'jane.sales@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
                'address' => '321 Commerce Blvd, Broker City, BC 54322',
            ],
            [
                'name' => 'Mike Seller',
                'email' => 'mike.seller@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
                'address' => '654 Trade Lane, Broker City, BC 54323',
            ],
            [
                'name' => 'Lisa Agent',
                'email' => 'lisa.agent@mail.com',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
                'address' => '987 Market Square, Broker City, BC 54324',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'role' => $userData['role'],
            ]);

            if ($user->role === 'admin') {
                Admin::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'address' => $userData['address'],
                    'status' => 'active',
                ]);
            } elseif ($user->role === 'broker') {
                Broker::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'address' => $userData['address'],
                    'status' => 'active',
                ]);
            }
        }

        $this->command->info('UserSeeder completed successfully!');
        $this->command->info('Created ' . User::count() . ' users');
        $this->command->info('Created ' . Admin::count() . ' admins');
        $this->command->info('Created ' . Broker::count() . ' brokers');
    }
}
