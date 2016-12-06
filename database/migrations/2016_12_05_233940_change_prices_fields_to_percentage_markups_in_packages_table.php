<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePricesFieldsToPercentageMarkupsInPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function ($table) {
            $table->renameColumn('retailPrice', 'retailMarkupPercentage');
            $table->renameColumn('trpzPrice', 'trpzMarkupPercentage');
            $table->renameColumn('jetSetGoPrice', 'jetSetGoMarkupPercentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function ($table) {
            $table->renameColumn('retailMarkupPercentage', 'retailPrice');
            $table->renameColumn('trpzMarkupPercentage', 'trpzPrice');
            $table->renameColumn('jetSetGoMarkupPercentage', 'jetSetGoPrice');
        });
    }
}
