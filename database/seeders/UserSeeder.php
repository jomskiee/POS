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
        // Create admin users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'address' => '123 Admin Street, Admin City, AC 12345',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Sarah Manager',
            'email' => 'sarah@mail.com',
            'address' => '456 Management Ave, Admin City, AC 12346',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Create broker users
        User::create([
            'name' => 'John Broker',
            'email' => 'john.broker@mail.com',
            'address' => '789 Sales Street, Broker City, BC 54321',
            'password' => Hash::make('12345678'),
            'role' => 'broker',
        ]);

        User::create([
            'name' => 'Jane Sales',
            'email' => 'jane.sales@mail.com',
            'address' => '321 Commerce Blvd, Broker City, BC 54322',
            'password' => Hash::make('12345678'),
            'role' => 'broker',
        ]);

        User::create([
            'name' => 'Mike Seller',
            'email' => 'mike.seller@mail.com',
            'address' => '654 Trade Lane, Broker City, BC 54323',
            'password' => Hash::make('12345678'),
            'role' => 'broker',
        ]);

        User::create([
            'name' => 'Lisa Agent',
            'email' => 'lisa.agent@mail.com',
            'address' => '987 Market Square, Broker City, BC 54324',
            'password' => Hash::make('12345678'),
            'role' => 'broker',
        ]);
    }
}
