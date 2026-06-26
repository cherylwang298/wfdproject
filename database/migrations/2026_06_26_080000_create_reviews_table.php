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
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            // $table->uuid('property_id'); // Relasi ke API Properties

            $table->string('user_id');
            $table->string('reservation_id');
            $table->string('property_id');

            $table->unsignedTinyInteger('rating'); // 1 sampai 5
            $table->text('comment')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');

            $table->timestamps(); // Kolom created_at otomatis ter-handle di sini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
