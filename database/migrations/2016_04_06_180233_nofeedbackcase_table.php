<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NofeedbackcaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('nofeedbackcases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team');
            $table->integer('agent');
            $table->text('reason');
            $table->integer('calls');
            $table->integer('emails');
            $table->text('actionplan');
            $table->date('casedate');
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
         Schema::drop('nofeedbackcases');
    }
}
