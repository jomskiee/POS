<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateUserRolesEmployeeToBroker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, update all existing 'employee' roles to 'broker'
        DB::table('users')
            ->where('role', 'employee')
            ->update(['role' => 'broker']);

        // Then modify the enum to replace 'employee' with 'broker'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'broker') DEFAULT 'broker'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // First, update all existing 'broker' roles to 'employee'
        DB::table('users')
            ->where('role', 'broker')
            ->update(['role' => 'employee']);

        // Then modify the enum to replace 'broker' with 'employee'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'employee') DEFAULT 'employee'");
    }
}