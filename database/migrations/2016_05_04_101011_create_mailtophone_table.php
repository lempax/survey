<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailtophoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('mailtophone', function (Blueprint $table) {
            $table->increments('id');
	    $table->text('loggedby');
            $table->date('date_created');
            $table->text('employee_name');
            $table->integer('case_id');
            $table->text('case_crr');
            $table->date('date_ofcase');
            $table->text('customer_reached');
            $table->text('reason');
            $table->text('status');
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
         Schema::drop('mailtophone');
    }
}
