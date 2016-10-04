<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function ($table) {
            $table->string('markup')->change();
            $table->dropColumn('hotel');
            $table->renameColumn('main_image', 'mainImage');
            $table->renameColumn('number_of_days', 'numberOfDays');
            $table->renameColumn('start_date', 'startDate');
            $table->renameColumn('end_date', 'endDate');
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
