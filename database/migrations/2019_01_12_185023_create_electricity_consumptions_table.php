<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectricityConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electricity_consumptions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('device_id');
            $table->foreign('device_id')->references('id')->on('meters');
            
            $table->dateTime('created_at');
            $table->float('sumDirectActive', 6, 3)->nullable();
            $table->float('sumInverseActive', 6, 3)->nullable();
            $table->float('sumDirectReactive', 6, 3)->nullable();
            $table->float('sumInverseReactive', 6, 3)->nullable();
            $table->float('t1DirectActive', 6, 3)->nullable();
            $table->float('t1InverseActive', 6, 3)->nullable();
            $table->float('t1DirectReactive', 6, 3)->nullable();
            $table->float('t1InverseRective', 6, 3)->nullable();
            $table->float('t2DirectActive', 6, 3)->nullable();
            $table->float('t2InverseActive', 6, 3)->nullable();
            $table->float('t2DirectReactive', 6, 3)->nullable();
            $table->float('t2InverseRective', 6, 3)->nullable();
            $table->float('t3DirectActive', 6, 3)->nullable();
            $table->float('t3InverseActive', 6, 3)->nullable();
            $table->float('t3DirectReactive', 6, 3)->nullable();
            $table->float('t3InverseRective', 6, 3)->nullable();
            $table->float('t4DirectActive', 6, 3)->nullable();
            $table->float('t4InverseActive', 6, 3)->nullable();
            $table->float('t4DirectReactive', 6, 3)->nullable();
            $table->float('t4InverseRective', 6, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electricity_consumptions');
    }
}
