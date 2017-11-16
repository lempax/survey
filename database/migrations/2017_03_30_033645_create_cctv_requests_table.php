<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCCTVRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cctv_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->dateTime('coverage_start');
            $table->dateTime('coverage_end');
            $table->string('approvers')->nullable();
            $table->string('download_link')->nullable();
            $table->smallInteger('status');
            $table->timestamps();
        });
        
        Schema::create('cctv_request_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requests_id');
            $table->integer('employee_id');
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
        Schema::drop('cctv_requests');
        Schema::drop('cctv_request_comments');
    }
}
