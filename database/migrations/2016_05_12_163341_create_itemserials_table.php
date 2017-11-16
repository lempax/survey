<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemserialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_serials', function (Blueprint $table) {
        $table->integer('item_id');
        $table->string('serial', 200);
        $table->enum('status', ['ONSTOCK', 'ISSUED', 'BUSTED']);
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
        Schema::drop('item_serials');
    }
}
