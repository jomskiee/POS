<?php

namespace Database\Seeders;

use App\Models\Broker;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some broker users first if they don't exist
        $brokerUsers = [
            [
                'name' => 'John Broker',
                'email' => 'john.broker@example.com',
                'password' => bcrypt('password'),
                'role' => 'broker',
                'address' => '123 Broker Street, City, State',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => bcrypt('password'),
                'role' => 'broker',
                'address' => '456 Sales Avenue, City, State',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'password' => bcrypt('password'),
                'role' => 'broker',
                'address' => '789 Commerce Blvd, City, State',
            ],
            [
                'name' => 'Sarah Davis',
                'email' => 'sarah.davis@example.com',
                'password' => bcrypt('password'),
                'role' => 'broker',
                'address' => '321 Business Park, City, State',
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert.wilson@example.com',
                'password' => bcrypt('password'),
                'role' => 'broker',
                'address' => '654 Trade Center, City, State',
            ],
        ];

        foreach ($brokerUsers as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Create broker record for each broker user
            Broker::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name,
                    'account_balance' => rand(1000, 50000) / 100, // Random balance between $10.00 and $500.00
                ]
            );
        }

        // Add additional brokers with different balances
        $additionalBrokers = [
            ['name' => 'Elite Broker Services', 'balance' => 15000.00],
            ['name' => 'Premium Sales Group', 'balance' => 25000.50],
            ['name' => 'Top Tier Brokers', 'balance' => 8750.25],
            ['name' => 'Professional Sales Inc', 'balance' => 12500.75],
            ['name' => 'Executive Brokers Ltd', 'balance' => 30000.00],
        ];

        foreach ($additionalBrokers as $brokerData) {
            // Create a user for each additional broker
            $user = User::create([
                'name' => $brokerData['name'] . ' Representative',
                'email' => strtolower(str_replace(' ', '.', $brokerData['name'])) . '@company.com',
                'password' => bcrypt('password'),
                'role' => 'broker',
                'address' => 'Corporate Office, Business District',
            ]);

            Broker::create([
                'user_id' => $user->id,
                'name' => $brokerData['name'],
                'account_balance' => $brokerData['balance'],
            ]);
        }

        $this->command->info('Broker seeder completed successfully!');
        $this->command->info('Created ' . User::where('role', 'broker')->count() . ' broker users');
        $this->command->info('Created ' . Broker::count() . ' broker records');
    }
}