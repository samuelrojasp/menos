<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('required_rank_id')->nullable();
            $table->tinyInteger('required_rank_count')->nullable();
            $table->integer('team_bonus_required_consumption')->nullable();
            $table->integer('required_consumption')->nullable();
            $table->integer('rank_bonus')->nullable();
            $table->tinyInteger('leadership_generation')->nullable();
            $table->tinyInteger('leadership_percentage')->nullable();
            $table->smallInteger('rank_level');
            $table->timestamps();
        });

        Schema::table('ranks', function (Blueprint $table) {
            $table->foreign('required_rank_id')
                    ->references('id')
                    ->on('ranks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranks');
    }
}
