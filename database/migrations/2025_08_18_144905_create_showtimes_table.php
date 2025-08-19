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
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
              $table->bigInteger('movie_id')->unsigned();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('base_price', 10, 2);
           $table->enum('status', ['upcoming', 'ongoing', 'ended'])->default('upcoming');
           $table->enum('is_active',['active', 'inactive'])->default('active');
            $table->bigInteger('hall_id')->unsigned();
            $table->foreign('hall_id')->references('id')->on('hall_cinemas')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');

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
        Schema::dropIfExists('Showtime');
    }
};
