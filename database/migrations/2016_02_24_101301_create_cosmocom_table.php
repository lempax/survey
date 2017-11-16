<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCosmocomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cosmocom', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->index();
            $table->integer('uid')->index();
            $table->string('agent_name');
            $table->string('state');
            $table->time('duration');
            $table->time('avg_statetime');
            $table->double('state_ratio', 5, 2);
            $table->time('total_duration');
            $table->integer('tid')->index();
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
        Schema::drop('cosmocom');
    }
}
