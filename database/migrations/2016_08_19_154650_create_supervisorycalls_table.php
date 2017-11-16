<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisorycallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('supervisorycalls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('case_number');
            $table->integer('requested_by');
            $table->integer('team');
            $table->integer('agent_name');
            $table->date('case_date');
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
         Schema::drop('supervisorycalls');
    }
}