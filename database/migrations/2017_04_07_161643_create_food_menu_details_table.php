<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodMenuDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodmenu_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('m_id')->unsigned();
            $table->integer('item_id')->unsigned();  
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
        Schema::drop('foodmenu_details');
    }
}
