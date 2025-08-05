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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned();
            $table->string('item_name');
            $table->enum('category', ['snacks', 'drinks', 'foods', 'others'])->default('others');
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('sale_price' , 10, 2);
            $table->integer('stock_level');
            $table->integer('reorder_level');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('stock',['in_stock', 'out_of_stock'])->default('in_stock');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict')->onUpdate('restrict');;
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
        Schema::dropIfExists('inventories');
    }
};
