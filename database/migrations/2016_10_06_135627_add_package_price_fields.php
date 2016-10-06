<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPackagePriceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function ($table) {
            $table->dropColumn('markup');
            $table->decimal('retailPrice');
            $table->decimal('trpzPrice');
            $table->decimal('jetSetGoPrice');
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
            $table->dropColumn(['retailPrice', 'trpzPrice', 'jetSetGoPrice']);
        });
    }
}
