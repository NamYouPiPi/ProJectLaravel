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
        DB::statement("ALTER TABLE suppliers MODIFY supplier_type ENUM('snacks', 'drinks', 'foods', 'movies', 'others') DEFAULT 'others'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            DB::statement("ALTER TABLE suppliers MODIFY supplier_type ENUM('snacks', 'drinks', 'foods', 'movid', 'others') DEFAULT 'others'");

        });
    }
};
