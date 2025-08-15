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
        Schema::create('hall_cinemas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('hall_location_id')->unsigned();
            $table->string('cinema_name');

            $table->integer('total_seats');
            $table->enum('hall_type', [
                'standard',
                'vip',
                'imax',
                '4dx',
                '3d',
                'dolby_atmos',
                'premium',
                'kids',
                'outdoor',
                'private'
            ])->default('standard');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreign('hall_location_id')->references('id')->on('hall_locations')->onDelete('restrict')->onUpdate('restrict');;
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
        Schema::dropIfExists('hall_cinemas');
    }
};
