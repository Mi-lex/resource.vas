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
            $table->integer('thermal_energy')->nullable();
            $table->integer('volume_flow_1')->nullable();
            $table->integer('volume_flow_2')->nullable();
            $table->integer('mass_flow_1')->nullable();
            $table->integer('mass_flow_2')->nullable();
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
