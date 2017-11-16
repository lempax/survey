<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMrformsremarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_forms_remarks', function (Blueprint $table) {
            $table->integer('mr_id');
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
        Schema::drop('mr_forms_remarks');
    }
}
