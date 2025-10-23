<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales_details', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['box_id']);

            // Change box_id column to JSON to store array of fish box IDs
            $table->json('box_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_details', function (Blueprint $table) {
            // Revert back to integer
            $table->integer('box_id')->change();

            // Recreate foreign key constraint
            $table->foreign('box_id')->references('id')->on('fish_boxes')->onDelete('cascade');
        });
    }
};
