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
        Schema::create('hall_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the hall location');
            $table->string('address')->comment('Address of the hall location');
           $table->string('city')->comment('City of the hall location');
           $table->string('state')->nullable()->comment('State of the hall location');
           $table->string('postal_code')->nullable()->comment('Postal code of the hall location');
           $table->string('country')->nullable()->comment('Country of the hall location');
           $table->string('phone')->nullable()->comment('Phone number of the hall location');
           $table->text('image')->nullable();
           $table->enum('status', ['active', 'inactive'])->default('active')->comment('Status of the hall location');
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
        Schema::dropIfExists('hall_locations');
    }
};
