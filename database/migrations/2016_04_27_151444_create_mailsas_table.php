<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailsas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('emp_name');
            $table->text('custID');
            $table->text('caseID');
            $table->text('contractID');
            $table->text('product_cycle');
            $table->date('date_upsells');
            $table->date('order_date');
            $table->text('notes');
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
        Schema::drop('mailsas');
    }
}
