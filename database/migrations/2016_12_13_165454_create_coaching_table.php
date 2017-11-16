<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coachings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('agent_id');
            $table->integer('creator');
            $table->integer('superior');
            $table->integer('manager');
            $table->text('content');
            $table->string('status');
            $table->text('attachment');
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
        Schema::drop('coachings');
    }
}
