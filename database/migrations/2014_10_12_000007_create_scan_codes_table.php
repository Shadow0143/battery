<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScanCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sacn_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ref_order')->nullable();
            $table->unsignedBigInteger('ref_order_details')->nullable();
            $table->longText('scan_code');
            $table->timestamps();
            $table->foreign('ref_order')->references('id')->on('orders');
            $table->foreign('ref_order_details')->references('id')->on('order_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sacn_codes');
    }
}
