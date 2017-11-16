<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('logged_by');
            $table->string('shift', 30);
            $table->text('tickets');
            $table->text('tasks');
            $table->text('summary');
            $table->string('status');
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
        Schema::drop('eos');
    }
}
