<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetentioncaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('retentioncase', function (Blueprint $table) {
            $table->increments('id');
            $table->text('loggedby');
            $table->integer('customer_id');
            $table->integer('contract_id');
            $table->text('email_address');
            $table->date('date');
            $table->text('current_price');
            $table->text('price_offered');
            $table->text('status');
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
        Schema::drop('retentioncase');
    }
}
