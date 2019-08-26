<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('type_id');
            $table->foreign('type_id')->references('id')
                ->on('types');

            $table->unsignedInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')
                ->on('drivers');

            $table->unsignedInteger('building_id')->nullable();
            $table->foreign('building_id')->references('id')
                ->on('buildings');

            $table->unsignedInteger('converter_id')->nullable();
            $table->foreign('converter_id')->references('id')
                ->on('converters');

            $table->string('name');
            $table->string('model');
            $table->integer('serial_number')->nullable();
            $table->mediumText('description');
            $table->date('verification_date');
            $table->boolean('active');

            $table->ipAddress('server_ip')->nullable();

            // Probable need to be removed
            $table->mediumInteger('rs_port')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meters');
    }
}