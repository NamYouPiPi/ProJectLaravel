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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('showtime_id')->unsigned();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('booking_fee', 10, 2)->default(0)->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0)->nullable();
            $table->decimal('final_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('showtime_id')->references('id')->on('showtimes')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
