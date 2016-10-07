<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hotelId');
            $table->string('name');
            $table->string('countryCode');
            $table->string('stateCode')->nullable();
            $table->string('city');
            $table->string('address');
            $table->decimal('longitude');
            $table->decimal('latitude');
            $table->string('category');
            $table->decimal('minAverPrice');
            $table->string('currency');
            $table->string('thumb');
            $table->integer('starsLevel');
            $table->text('countryCode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotels');
    }
}
