<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('object_id');
            $table->foreign('object_id')->references('id')->on('miltary_objects');

            $table->unsignedInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors');

            $table->string('name');
            $table->mediumInteger('area');
            $table->tinyInteger('floors');
            $table->mediumInteger('max_emit_power')->nullable();
            $table->mediumInteger('max_reserve_power')->nullable();
            $table->year('created_at')->nullable();
            $table->year('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
