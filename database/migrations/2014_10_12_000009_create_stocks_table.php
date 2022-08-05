<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ref_product')->nullable();
            $table->unsignedBigInteger('ref_stock_detail')->nullable();
            $table->text('quantity')->nullable();
            $table->timestamps();
            $table->foreign('ref_product')->references('id')->on('products');
            $table->foreign('ref_stock_detail')->references('id')->on('stock_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
