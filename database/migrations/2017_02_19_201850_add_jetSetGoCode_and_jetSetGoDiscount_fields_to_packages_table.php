<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJetSetGoCodeAndJetSetGoDiscountFieldsToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function(Blueprint $table){
            $table->string('jetSetGoCode')->nullable();
            $table->decimal('jetSetGoDiscount', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function(Blueprint $table){
            $table->dropColumn(['jetSetGoCode','jetSetGoDiscount']);
        });
    }
}
