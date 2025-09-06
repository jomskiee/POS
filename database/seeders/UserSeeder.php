<?php

namespace Database\Seeders;

use App\Models\Broker;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define users data
        $users = [
            // Admin users
            [
                'name' => 'Admin User',
                'email' => 'admin@mail.com',
                'address' => '123 Admin Street, Admin City, AC 12345',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'name' => 'Sarah Manager',
                'email' => 'sarah@mail.com',
                'address' => '456 Management Ave, Admin City, AC 12346',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            // Broker users
            [
                'name' => 'John Broker',
                'email' => 'john.broker@mail.com',
                'address' => '789 Sales Street, Broker City, BC 54321',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
            ],
            [
                'name' => 'Jane Sales',
                'email' => 'jane.sales@mail.com',
                'address' => '321 Commerce Blvd, Broker City, BC 54322',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
            ],
            [
                'name' => 'Mike Seller',
                'email' => 'mike.seller@mail.com',
                'address' => '654 Trade Lane, Broker City, BC 54323',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
            ],
            [
                'name' => 'Lisa Agent',
                'email' => 'lisa.agent@mail.com',
                'address' => '987 Market Square, Broker City, BC 54324',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert.wilson@mail.com',
                'address' => '111 Business Park, Broker City, BC 54325',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@mail.com',
                'address' => '222 Enterprise Ave, Broker City, BC 54326',
                'password' => Hash::make('12345678'),
                'role' => 'broker',
            ],
        ];

        // Create users and brokers
        foreach ($users as $userData) {
            $user = User::create($userData);

            // If user role is broker, create a corresponding broker record
            if ($user->role === 'broker') {
                Broker::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'account_balance' => $this->generateRandomBalance(),
                ]);
            }
        }

        $this->command->info('UserSeeder completed successfully!');
        $this->command->info('Created ' . User::count() . ' users');
        $this->command->info('Created ' . Broker::count() . ' brokers');
    }

    /**
     * Generate a random balance for brokers
     */
    private function generateRandomBalance()
    {
        // Generate random balance between $100.00 and $50,000.00
        return rand(10000, 5000000) / 100;
    }
}
