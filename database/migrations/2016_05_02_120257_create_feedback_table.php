<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
        $table->increments('id');
        $table->text('email');
        $table->text('agent');
        $table->text('other_agent');
        $table->text('customer_number');
        $table->text('case_id');
        $table->text('problem');
	$table->text('solution');
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
        Schema::drop('feedback');
    }
}
