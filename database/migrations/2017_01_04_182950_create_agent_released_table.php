<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentReleasedTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agent_released', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rid', 15);
            $table->string('team', 15);
            $table->string('jan_total', 15);
            $table->string('jan_calls', 15);
            $table->string('jan_ave', 15);
            $table->string('feb_total', 15);
            $table->string('feb_calls', 15);
            $table->string('feb_ave', 15);
            $table->string('mar_total', 15);
            $table->string('mar_calls', 15);
            $table->string('mar_ave', 15);
            $table->string('april_total', 15);
            $table->string('april_calls', 15);
            $table->string('april_ave', 15);
            $table->string('may_total', 15);
            $table->string('may_calls', 15);
            $table->string('may_ave', 15);
            $table->string('june_total', 15);
            $table->string('june_calls', 15);
            $table->string('june_ave', 15);
            $table->string('july_total', 15);
            $table->string('july_calls', 15);
            $table->string('july_ave', 15);
            $table->string('aug_total', 15);
            $table->string('aug_calls', 15);
            $table->string('aug_ave', 15);
            $table->string('sept_total', 15);
            $table->string('sept_calls', 15);
            $table->string('sept_ave', 15);
            $table->string('oct_total', 15);
            $table->string('oct_calls', 15);
            $table->string('oct_ave', 15);
            $table->string('nov_total', 15);
            $table->string('nov_calls', 15);
            $table->string('nov_ave', 15);
            $table->string('dec_total', 15);
            $table->string('dec_calls', 15);
            $table->string('dec_ave', 15);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('agent_released');
    }

}
