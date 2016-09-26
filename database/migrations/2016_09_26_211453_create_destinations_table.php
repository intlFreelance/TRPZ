<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('destinations', function (Blueprint $table) {
             $table->increments('id');
             $table->string('name');
             $table->string('destinationId');
             $table->string('provider');
             $table->integer('elementType');
             $table->string('destinationCode')->nullable();
             $table->string('cityLatitude')->nullable();
             $table->string('cityLongitude')->nullable();
             $table->string('parent_destinationId')->nullable();
             $table->string('parent_id')->nullable();
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::drop('destinations');
     }
}
