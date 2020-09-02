<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospect_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->longText('notes');
            $table->foreignId('prospect_id');
            $table->unsignedInteger('user_id')->constrained();
            $table->timestamps();

            $table->foreign('prospect_id')->references('id')->on('prospectos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prospect_activities');
    }
}
