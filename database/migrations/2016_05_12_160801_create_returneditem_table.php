<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturneditemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returneditem', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid');
            $table->integer('item_id');
            $table->text('manufacturer');
            $table->text('serial');
            $table->text('condition');
            $table->text('warranty');
            $table->text('fixed');
            $table->text('disposed');
            $table->integer('quantity');
            $table->text('username');
            $table->text('logged_by');
            $table->integer('date');
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
        Schema::drop('returneditem');
    }
}
