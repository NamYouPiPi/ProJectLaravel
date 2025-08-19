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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hall_id')->unsigned();
            $table->bigInteger('seat_type_id')->unsigned();
            $table->string('seat_number');
            $table->string('seat_row');
            $table->enum('status',[ 'available',
                'reserved',
                'booked',
                'cancelled',
                'blocked',
                'broken'])->default('reserved');
            $table->foreign('hall_id')->references('id')->on('hall_cinemas')->onDelete('cascade');
            $table->foreign('seat_type_id')->references('id')->on('seat_types')->onDelete('cascade');
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
        Schema::dropIfExists('seats');
    }
};
