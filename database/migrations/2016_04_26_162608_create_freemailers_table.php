<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreemailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freemailers', function (Blueprint $table) {
        $table->increments('id');
        $table->text('name');
        $table->text('customer_id');
        $table->text('case_id');
        $table->text('medium');
        $table->text('email');
        $table->text('description');
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
        Schema::drop('freemailers');
    }
}
