<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PointSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('pointsystem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('personid');
            $table->integer('kodus');
            $table->integer('crr');
            $table->integer('nps');
            $table->integer('aht');
            $table->integer('sas');
            $table->integer('agentposfb');
            $table->integer('nolate');
            $table->integer('noabsent');
            $table->integer('ootd');
            $table->integer('trivia');
            $table->integer('totalpoints');
            $table->timestamps('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pointsystem');
    }
}
