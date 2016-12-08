<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropRoomtypesAndHotelRoomtypesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('roomtypes');
        Schema::drop('hotel_roomtypes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('roomtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('roomTypeId');
            $table->string('name');
        });
        
        Schema::create('hotel_roomtypes', function(Blueprint $table){
            $table->increments('id');
            $table->string('roomtypeId');
            $table->integer('hotel_id')->unsigned();
        });
    }
}
