<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeatConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heat_consumptions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('device_id');
            $table->foreign('device_id')->references('id')->on('meters');
            
            $table->dateTime('created_at');
            $table->integer('thermal_energy');
            $table->integer('volume_flow_1');
            $table->integer('volume_flow_2');
            $table->integer('mass_flow_1');
            $table->integer('mass_flow_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('heat_consumptions');
    }
}
