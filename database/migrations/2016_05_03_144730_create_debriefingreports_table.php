<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebriefingreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debriefingreports', function (Blueprint $table) {
        $table->increments('id');
        $table->text('name');
        $table->text('reporttype');
        $table->text('category');
        $table->text('shift');
        $table->text('content');
        $table->text('status');
        $table->integer('week');
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
       Schema::drop('debriefingreports');
    }
}
