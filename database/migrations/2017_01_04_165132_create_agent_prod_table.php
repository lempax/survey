<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentProdTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agent_prod', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rid', 15);
            $table->string('team', 15);
            $table->string('teamname', 15);
            $table->string('jan_diff', 15);
            $table->string('jan_email', 15);
            $table->string('jan_sse', 15);
            $table->string('jan_calls', 15);
            $table->string('jan_prod', 15);
            $table->string('feb_diff', 15);
            $table->string('feb_email', 15);
            $table->string('feb_sse', 15);
            $table->string('feb_calls', 15);
            $table->string('feb_prod', 15);
            $table->string('mar_diff', 15);
            $table->string('mar_email', 15);
            $table->string('mar_sse', 15);
            $table->string('mar_calls', 15);
            $table->string('mar_prod', 15);
            $table->string('april_diff', 15);
            $table->string('april_email', 15);
            $table->string('april_sse', 15);
            $table->string('april_calls', 15);
            $table->string('april_prod', 15);
            $table->string('may_diff', 15);
            $table->string('may_email', 15);
            $table->string('may_sse', 15);
            $table->string('may_calls', 15);
            $table->string('may_prod', 15);
            $table->string('june_diff', 15);
            $table->string('june_email', 15);
            $table->string('june_sse', 15);
            $table->string('june_calls', 15);
            $table->string('june_prod', 15);
            $table->string('july_diff', 15);
            $table->string('july_email', 15);
            $table->string('july_sse', 15);
            $table->string('july_calls', 15);
            $table->string('july_prod', 15);
            $table->string('aug_diff', 15);
            $table->string('aug_email', 15);
            $table->string('aug_sse', 15);
            $table->string('aug_calls', 15);
            $table->string('aug_prod', 15);
            $table->string('sept_diff', 15);
            $table->string('sept_email', 15);
            $table->string('sept_sse', 15);
            $table->string('sept_calls', 15);
            $table->string('sept_prod', 15);
            $table->string('oct_diff', 15);
            $table->string('oct_email', 15);
            $table->string('oct_sse', 15);
            $table->string('oct_calls', 15);
            $table->string('oct_prod', 15);
            $table->string('nov_diff', 15);
            $table->string('nov_email', 15);
            $table->string('nov_sse', 15);
            $table->string('nov_calls', 15);
            $table->string('nov_prod', 15);
            $table->string('dec_diff', 15);
            $table->string('dec_email', 15);
            $table->string('dec_sse', 15);
            $table->string('dec_calls', 15);
            $table->string('dec_prod', 15);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('agent_prod');
    }

}
