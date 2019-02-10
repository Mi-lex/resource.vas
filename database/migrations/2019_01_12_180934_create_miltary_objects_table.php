<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiltaryObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miltary_objects', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('district_id');
            $table->foreign('district_id')->references('id')->on('miltary_districts');
            
            $table->string('name');
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miltary_objects');
    }
}
