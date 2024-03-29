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
            $table->float('sumDirectActive', 9, 3)->nullable();
            $table->float('sumInverseActive', 9, 3)->nullable();
            $table->float('sumDirectReactive', 9, 3)->nullable();
            $table->float('sumInverseReactive', 9, 3)->nullable();
            $table->float('t1DirectActive', 9, 3)->nullable();
            $table->float('t1InverseActive', 9, 3)->nullable();
            $table->float('t1DirectReactive', 9, 3)->nullable();
            $table->float('t1InverseReactive', 9, 3)->nullable();
            $table->float('t2DirectActive', 9, 3)->nullable();
            $table->float('t2InverseActive', 9, 3)->nullable();
            $table->float('t2DirectReactive', 9, 3)->nullable();
            $table->float('t2InverseReactive', 9, 3)->nullable();
            $table->float('t3DirectActive', 9, 3)->nullable();
            $table->float('t3InverseActive', 9, 3)->nullable();
            $table->float('t3DirectReactive', 9, 3)->nullable();
            $table->float('t3InverseReactive', 9, 3)->nullable();
            $table->float('t4DirectActive', 9, 3)->nullable();
            $table->float('t4InverseActive', 9, 3)->nullable();
            $table->float('t4DirectReactive', 9, 3)->nullable();
            $table->float('t4InverseReactive', 9, 3)->nullable();
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
