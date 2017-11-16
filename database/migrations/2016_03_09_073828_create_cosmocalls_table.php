<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCosmocallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cosmocalls', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->index();
            $table->integer('uid')->index();
            $table->string('agent_name');
            $table->tinyInteger('calls_handled');
            $table->tinyInteger('outgoing_calls');
            $table->tinyInteger('conference_transferred_calls');
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
        Schema::drop('cosmocalls');
    }
}
