<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHotelIdRoomTypeIdStartDateEndDateFieldsToPurchasePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_packages', function(Blueprint $table){
            $table->date('startDate');
            $table->date('endDate');
            $table->integer('hotelId')->unsigned();
            $table->integer('roomTypeId')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_packages', function(Blueprint $table){
            $table->dropColumn(['startDate', 'endDate', 'hotelId', 'roomTypeId']);
        });
    }
}
