<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBugrequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugrequest', function (Blueprint $table) {
            $table->increments('id');
            $table->text('loggedby');
            $table->text('category');
            $table->text('subject');
            $table->integer('customer_id');
            $table->integer('contract_id');
            $table->integer('tech_id');
            $table->integer('project_id');
            $table->text('description');
            $table->text('solution');
            $table->text('behavior');
            $table->date('date_occurrence');
            $table->text('instruction');
            $table->string('filename');
            $table->string('mime');
            $table->string('original_filename');
            $table->text('browser1');
            $table->text('browser2');
            $table->text('os');
            $table->text('recipient');
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
        Schema::drop('bugrequest');
    }
}
