<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
        $table->increments('id');
        $table->enum('type', ['regular', 'equipment']);
        $table->string('name', 255);
        $table->string('price', 10);
        $table->smallInteger('quantity');
        $table->smallInteger('cid');
        $table->string('supplier', 255);
        $table->string('addn_details', 255);
        $table->date('warranty_date');
        $table->date('date_delivered');
        $table->tinyInteger('verified');
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
        Schema::drop('items');
    }
}
