<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueditemTable extends Migration
{
    public function up()
    {
       Schema::create('issueditem', function (Blueprint $table) {
            $table->integer('issued_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->text('serial');
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
        Schema::drop('issueditem');
    }
}
