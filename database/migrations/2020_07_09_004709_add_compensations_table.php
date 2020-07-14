<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompensationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensations', function(Blueprint $table){
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->dateTime('fulfilled_at')->nullable();
            $table->foreignId('user_id');
            $table->bigInteger('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('compensations');
    }
}
