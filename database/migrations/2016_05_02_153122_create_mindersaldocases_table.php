<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMindersaldocasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mindersaldocases', function (Blueprint $table) {
        $table->increments('id');
        $table->text('emp_name');
        $table->text('customer_id');
        $table->text('contract_id');
        $table->date('date_updated');
	$table->date('date_mindersaldo_lock');
        $table->text('confirm');
        $table->integer('week');
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
       Schema::drop('mindersaldocases');
    }
}
