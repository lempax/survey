<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaseTrackingTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->index();
            $table->enum('medium', ['Telefon', 'Mail'])->default('Telefon');
            $table->string('workpool', 100);
            $table->string('tracking1', 200);
            $table->string('tracking2', 200);
            $table->string('product_line', 200);
            $table->integer('product_id');
            $table->string('product_desc', 200);
            $table->integer('caseid');
            $table->integer('customerid');
            $table->integer('uid')->index();
            $table->integer('agent_id');
            $table->string('agent_name', 50);
            $table->string('team', 50);
            $table->tinyInteger('case_count');
            $table->tinyInteger('bl_count');
            $table->string('avg_case_editing_time', 10);
            $table->string('avg_editing_time', 10);
            $table->string('avg_sas_editing_time', 10);
            $table->integer('tid')->index();
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
        Schema::drop('case_tracking');
    }

}
