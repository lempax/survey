<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepaireditemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repaireditem', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->text('name');
            $table->text('department');
            $table->text('description');
            $table->text('brand');
            $table->text('serial');
            $table->text('defect');
            $table->text('status');
            $table->text('request_id');
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
        Schema::drop('repaireditem');
    }
}
