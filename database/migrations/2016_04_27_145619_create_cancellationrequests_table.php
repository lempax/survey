<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancellationrequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellationrequests', function (Blueprint $table) {
        $table->increments('id');
        $table->text('name');
        $table->text('customer_id');
        $table->text('contract_id');
        $table->text('email');
        $table->text('product_id');
        $table->date('cancellation_date');
	$table->date('effective_date');
        $table->text('reason');
        $table->text('type');
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
       Schema::drop('cancellationrequests');
    }
}
