<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdfFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_file', function (Blueprint $table) {
            $table->increments('pdf_id');
            $table->text('pdf_name');
            $table->text('pdf_title');
            $table->text('uploader');
            $table->integer('type');
            $table->date('date_uploaded');
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
        Schema::drop('pdf_file');
    }
}
