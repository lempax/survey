<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsSasLoggerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('us_sasloggers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team');
            $table->integer('agent');
            $table->date('orderdate');
            $table->text('caseid');
            $table->text('contractid');
            $table->text('desc');
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
        Schema::drop('us_sasloggers');
    }
}
