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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('payment_reference')->unique();
            $table->enum('payment_method', ['credit_card', 'paypal', 'bank_transfer']);
            $table->date('payment_time');
            $table->decimal('amount_paid', 10, 2);
            $table->string('transaction_id')->unique();
            $table->text('gateway_response');
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->text('refund_reason')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
