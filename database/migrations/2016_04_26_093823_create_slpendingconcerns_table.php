<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlpendingconcernsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slpendingconcerns', function (Blueprint $table) {
            $table->increments('id');
            $table->text('emp_name');
            $table->text('subject');
            $table->text('status');
            $table->text('concern');
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
        Schema::drop('slpendingconcerns');
    }
}
