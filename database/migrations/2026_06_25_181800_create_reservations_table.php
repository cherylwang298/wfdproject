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
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->string('unit_id'); 
            $table->dateTime('check_in')->nullable(); 
            $table->dateTime('check_out')->nullable();
            $table->unsignedInteger('total_price');
            // $table->string('status')->default('pending');
            $table->enum('status', ['confirmed', 'finished', 'cancelled'])->default('confirmed');
            $table->string('payment_status')->default('unpaid');
            $table->string('guest_name');
            $table->string('guest_phone_number');
            $table->string('guest_email');
            $table->string('promo_id')->nullable(); 
           
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('promo_id')->references('id')->on('promos')->onDelete('set null');
           
            $table->timestamps();

           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
