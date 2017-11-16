<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingOutboundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_outbound', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user', 50);
            $table->integer('custid');
            $table->integer('contractid');
            $table->integer('caseid');
            $table->text('notes');
            $table->datetime('date');
            $table->timestamps('timestamp');
            $table->text('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('billing_outbound');
    }
}
