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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('flight_id'); // Relasi ke API Flights
            $table->uuid('flight_booking_id');
            $table->uuid('passenger_id');
            $table->string('seat_number');
            $table->enum('seat_type', ['business', 'economy']);
            $table->unsignedInteger('price');
            $table->timestamps();

            $table->foreign('flight_booking_id')->references('id')->on('flight_bookings')->onDelete('cascade');
            $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
