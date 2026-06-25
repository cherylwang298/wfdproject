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
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->uuid('unit_id'); // Relasi ke API Units
            $table->dateTime('check_in')->nullable(); // Menghindari error default value
            $table->dateTime('check_out')->nullable();
            $table->unsignedInteger('total_price');
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->string('guest_name');
            $table->string('guest_phone_number');
            $table->string('guest_email');
            $table->uuid('promo_id')->nullable(); 
            $table->timestamps();

            $table->foreign('promo_id')->references('id')->on('promos')->onDelete('set null');
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
