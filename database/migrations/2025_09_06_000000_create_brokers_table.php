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
        Schema::create('brokers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address')->nullable();
            $table->decimal('account_balance', 10, 2)->default(0.00);
            $table->enum('status', ['active', 'deactivated'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            // Add indexes for better performance
            $table->index('user_id');
            $table->index('account_balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brokers');
    }
};