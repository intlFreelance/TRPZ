<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionFieldsToPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['description']);
            $table->text('amenities')->nullable();
            $table->text('highlights')->nullable();
            $table->text('finePrint')->nullable();
            $table->text('tripItinerary')->nullable();
            $table->text('frequentlyAskedQuestions')->nullable();
            $table->text('otherNotes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->text('description');
            $table->dropColumn(['amenities','highlights', 'finePrint','tripItinerary','frequentlyAskedQuestions','otherNotes']);
        });
    }
}
