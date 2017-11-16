<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnedmanufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returnedmanufacturers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('date');
            $table->text('manufacturer_id');
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
        Schema::drop('returnedmanufacturers');
    }
}
