<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentAhtTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agent_aht', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rid', 15);
            $table->string('team', 15);
            $table->string('jan_login', 15);
            $table->string('jan_aht_out', 15);
            $table->string('jan_in_out', 15);
            $table->string('jan_aht_in', 15);
            $table->string('feb_login', 15);
            $table->string('feb_aht_out', 15);
            $table->string('feb_in_out', 15);
            $table->string('feb_aht_in', 15);
            $table->string('mar_login', 15);
            $table->string('mar_aht_out', 15);
            $table->string('mar_in_out', 15);
            $table->string('mar_aht_in', 15);
            $table->string('april_login', 15);
            $table->string('april_aht_out', 15);
            $table->string('april_in_out', 15);
            $table->string('april_aht_in', 15);
            $table->string('may_login', 15);
            $table->string('may_aht_out', 15);
            $table->string('may_in_out', 15);
            $table->string('may_aht_in', 15);
            $table->string('june_login', 15);
            $table->string('june_aht_out', 15);
            $table->string('june_in_out', 15);
            $table->string('june_aht_in', 15);
            $table->string('july_login', 15);
            $table->string('july_aht_out', 15);
            $table->string('july_in_out', 15);
            $table->string('july_aht_in', 15);
            $table->string('aug_login', 15);
            $table->string('aug_aht_out', 15);
            $table->string('aug_in_out', 15);
            $table->string('aug_aht_in', 15);
            $table->string('sept_login', 15);
            $table->string('sept_aht_out', 15);
            $table->string('sept_in_out', 15);
            $table->string('sept_aht_in', 15);
            $table->string('oct_login', 15);
            $table->string('oct_aht_out', 15);
            $table->string('oct_in_out', 15);
            $table->string('oct_aht_in', 15);
            $table->string('nov_login', 15);
            $table->string('nov_aht_out', 15);
            $table->string('nov_in_out', 15);
            $table->string('nov_aht_in', 15);
            $table->string('dec_login', 15);
            $table->string('dec_aht_out', 15);
            $table->string('dec_in_out', 15);
            $table->string('dec_aht_in', 15);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('agent_aht');
    }

}
