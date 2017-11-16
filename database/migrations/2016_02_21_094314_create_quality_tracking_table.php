<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualityTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->index();
            $table->enum('medium', ['Telefon', 'Mail'])->default('Telefon');
            $table->string('workpool', 100);
            $table->integer('product_id');
            $table->string('product_desc', 200);
            $table->integer('caseid');
            $table->tinyInteger('qfb_competence');
            $table->tinyInteger('qfb_first_request');
            $table->tinyInteger('qfb_friendliness');
            $table->tinyInteger('qfb_request_customer_effort_contact');
            $table->tinyInteger('qfb_request_resolved');
            $table->tinyInteger('qfb_response');
            $table->tinyInteger('qfb_solution');
            $table->string('qfb_netpromoter_score', 5);
            $table->text('qfb_comment_praise');
            $table->text('qfb_comment_suggestions');
            $table->integer('uid')->index();
            $table->string('agent_name', 50);
            $table->string('team', 50);
            $table->string('department', 50);
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
        Schema::drop('quality_tracking');
    }
}
