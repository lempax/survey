<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUs3hreportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('us3hreport', function (Blueprint $table) {
            $table->increments('report_id');
            $table->integer('logged_by');
            $table->text('availability');
            $table->text('absenteeism');
            $table->text('emails');
            $table->text('products');
            $table->text('sas');
            $table->text('attachments');
            $table->text('highlights');
            $table->text('lowlights');
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
        Schema::drop('us3hreport');
    }
}
