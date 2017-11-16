<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailcancelledcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailcancelledcases', function (Blueprint $table) {
            $table->increments('id');
            $table->text('emp_name');
            $table->text('custID');
            $table->text('contractID');
            $table->text('email');
            $table->text('prodID');
            $table->date('date_cancelled');
            $table->date('date_effect');
            $table->text('reason');
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
        Schema::drop('mailcancelledcases');
    }
}
