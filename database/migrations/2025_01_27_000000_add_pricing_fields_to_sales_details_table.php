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
            $table->decimal('unit_price', 10, 2)->nullable()->after('item_description');
            $table->integer('quantity')->default(1)->after('unit_price');
            $table->decimal('sub_total', 10, 2)->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_details', function (Blueprint $table) {
            $table->dropColumn(['unit_price', 'quantity', 'sub_total']);
        });
    }
};
