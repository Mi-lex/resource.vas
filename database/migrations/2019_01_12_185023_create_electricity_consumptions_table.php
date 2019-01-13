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
            $table->smallInteger('device_id');
            $table->dateTime('created_at');
            $table->float('sumDirectActive', 5, 3);
            $table->float('sumInverseActive', 5, 3);
            $table->float('sumDirectReactive', 5, 3);
            $table->float('sumInverseReactive', 5, 3);
            $table->float('t1DirectActive', 5, 3);
            $table->float('t1InverseActive', 5, 3);
            $table->float('t1DirectReactive', 5, 3);
            $table->float('t1InverseRective', 5, 3);
            $table->float('t2DirectActive', 5, 3);
            $table->float('t2InverseActive', 5, 3);
            $table->float('t2DirectReactive', 5, 3);
            $table->float('t2InverseRective', 5, 3);
            $table->float('t3DirectActive', 5, 3);
            $table->float('t3InverseActive', 5, 3);
            $table->float('t3DirectReactive', 5, 3);
            $table->float('t3InverseRective', 5, 3);
            $table->float('t4DirectActive', 5, 3);
            $table->float('t4InverseActive', 5, 3);
            $table->float('t4DirectReactive', 5, 3);
            $table->float('t4InverseRective', 5, 3);
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
