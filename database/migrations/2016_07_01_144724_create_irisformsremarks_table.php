<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIrisformsremarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iris_forms_remarks', function (Blueprint $table) {
            $table->integer('iris_id');
            $table->integer('changed_by');
            $table->text('remarks');
            $table->tinyInteger('visibility');
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
        Schema::drop('iris_forms_remarks');
    }
}
