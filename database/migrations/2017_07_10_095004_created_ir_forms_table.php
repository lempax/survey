<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedIrFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('irforms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agentid');
            $table->integer('supid');
            $table->string('team');
            $table->string('type');
            $table->text('content');
            $table->text('summary');
            $table->text('attachments');
            $table->string('minutes');
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
        Schema::drop('irforms');
    }
}
