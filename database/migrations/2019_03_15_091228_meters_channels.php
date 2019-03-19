<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MetersChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meters_channels', function (Blueprint $table) {
            $table->unsignedInteger('meter_id')->nullable();
            $table->foreign('meter_id')->references('id')
                ->on('meters');

            $table->smallInteger('channel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
