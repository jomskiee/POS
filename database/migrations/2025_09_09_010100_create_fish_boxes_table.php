<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fish_boxes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('broker_id')->constrained('brokers')->onDelete('cascade');
            $table->uuid('qr_code')->unique();
            $table->foreignId('fish_type_id')->constrained('fish_types')->onDelete('cascade');
            $table->enum('status', ['In Stock', 'Sold', 'Returned', 'Missing'])->default('In Stock');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fish_boxes');
    }
};
