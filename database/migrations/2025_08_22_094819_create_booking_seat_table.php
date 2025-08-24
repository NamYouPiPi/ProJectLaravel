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
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('seat_id')->constrained('seats');
            $table->decimal('price', 10, 2);
            $table->enum('status', ['reserved', 'confirmed', 'cancelled'])->default('reserved');
            $table->timestamps();

            // Each seat can only be booked once per booking
            $table->unique(['booking_id', 'seat_id']);
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_seat');
    }
};
