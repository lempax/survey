<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAssetsItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_items', function (Blueprint $table) {
            $table->increments('id');
            $table->text('category');
            $table->text('name');
            $table->text('serial');
            $table->integer('quantity');
            $table->text('supplier');
            $table->date('date_delivered');
            $table->date('warranty_date');
            $table->text('logged_by');
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
         Schema::drop('assets_items');
    }
}
