<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrderCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order_comments', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('uid');
            $table->text('comment');
            $table->tinyInteger('private');
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
        Schema::drop('job_order_comments');
    }
}
