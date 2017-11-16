<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentSasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agent_sas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rid', 15);
            $table->string('team', 15);
            $table->string('jan_sas', 15);
            $table->string('jan_calls', 15);
            $table->string('jan_cr', 15);
            $table->string('feb_sas', 15);
            $table->string('feb_calls', 15);
            $table->string('feb_cr', 15);
            $table->string('mar_sas', 15);
            $table->string('mar_calls', 15);
            $table->string('mar_cr', 15);
            $table->string('april_sas', 15);
            $table->string('april_calls', 15);
            $table->string('april_cr', 15);
            $table->string('may_sas', 15);
            $table->string('may_calls', 15);
            $table->string('may_cr', 15);
            $table->string('june_sas', 15);
            $table->string('june_calls', 15);
            $table->string('june_cr', 15);
            $table->string('july_sas', 15);
            $table->string('july_calls', 15);
            $table->string('july_cr', 15);
            $table->string('aug_sas', 15);
            $table->string('aug_calls', 15);
            $table->string('aug_cr', 15);
            $table->string('sept_sas', 15);
            $table->string('sept_calls', 15);
            $table->string('sept_cr', 15);
            $table->string('oct_sas', 15);
            $table->string('oct_calls', 15);
            $table->string('oct_cr', 15);
            $table->string('nov_sas', 15);
            $table->string('nov_calls', 15);
            $table->string('nov_cr', 15);
            $table->string('dec_sas', 15);
            $table->string('dec_calls', 15);
            $table->string('dec_cr', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('agent_sas');
    }

}
