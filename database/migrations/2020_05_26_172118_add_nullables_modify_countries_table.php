<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullablesModifyCountriesTable extends Migration
{
    /**
      * Run the migrations.
      *
      * @return void
      */
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->integer('numcode')->nullable()->change();
            $table->integer('phonecode')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iso3_modify_countries', function (Blueprint $table) {
            //
        });
    }
}
