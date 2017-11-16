<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJoborderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order', function (Blueprint $table) {
            $table->increments('id');
            $table->text('type');
            $table->text('priority');
            $table->text('title');
            $table->text('description');
            $table->text('attachments');
            $table->enum('status', ['pending', 'approved', 'disapproved', 'assigned', 'ongoing', 'closed']);
            $table->text('dreason');
            $table->text('created_by');
            $table->text('assigned_to');
            $table->text('tid');
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
         Schema::drop('job_order');
    }
}