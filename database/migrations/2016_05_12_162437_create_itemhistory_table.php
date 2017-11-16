<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_history', function (Blueprint $table) {
        $table->integer('item_id');
        $table->enum('history_type', ['ADD', 'UPDATE', 'DELETE', 'ISSUED', 'RETURNED']);
        $table->text('description');
        $table->string('changed_by', 50);
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
       Schema::drop('item_history');
    }
}
