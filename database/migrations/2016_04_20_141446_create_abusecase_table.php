<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbusecaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abusecase', function (Blueprint $table) {
            $table->increments('id');
            $table->text('employee_name');
            $table->integer('case_id');
            $table->integer('customer_id');
            $table->integer('contract_id');
            $table->text('day_called');
            $table->date('date_called');
            $table->text('comment');
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
        Schema::drop('abusecase');
    }
}
