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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->integer('duration_minutes');

            $table->text('description')->nullable();
            $table->string('author');
            $table->string('rating');
            $table->string('language');
            $table->string('poster_url');
            $table->string('trailer_url');
            $table->date('release_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->bigInteger('classification_id')->unsigned();
            $table->bigInteger('genre_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('restrict')->onUpdate('restrict');;
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict')->onUpdate('restrict');;
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('restrict')->onUpdate('restrict');;
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
        Schema::dropIfExists('movies');
    }
};
