<?php

namespace Database\Seeders;

use App\Models\Broker;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks to allow truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables in correct order (child tables first)
        Broker::truncate();
        User::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Run seeders
        $this->call(UserSeeder::class);
    }
}
