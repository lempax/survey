<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentCQNTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agent_CQN', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rid', 15);
            $table->string('team', 15);
            $table->string('jan_feed', 15);
            $table->string('jan_q', 15);
            $table->string('jan_fcr', 15);
            $table->string('jan_crr', 15);
            $table->string('jan_nps', 15);
            $table->string('feb_feed', 15);
            $table->string('feb_q', 15);
            $table->string('feb_fcr', 15);
            $table->string('feb_crr', 15);
            $table->string('feb_nps', 15);
            $table->string('mar_feed', 15);
            $table->string('mar_q', 15);
            $table->string('mar_fcr', 15);
            $table->string('mar_crr', 15);
            $table->string('mar_nps', 15);
            $table->string('april_feed', 15);
            $table->string('april_q', 15);
            $table->string('april_fcr', 15);
            $table->string('april_crr', 15);
            $table->string('april_nps', 15);
            $table->string('may_feed', 15);
            $table->string('may_q', 15);
            $table->string('may_fcr', 15);
            $table->string('may_crr', 15);
            $table->string('may_nps', 15);
            $table->string('june_feed', 15);
            $table->string('june_q', 15);
            $table->string('june_fcr', 15);
            $table->string('june_crr', 15);
            $table->string('june_nps', 15);
            $table->string('july_feed', 15);
            $table->string('july_q', 15);
            $table->string('july_fcr', 15);
            $table->string('july_crr', 15);
            $table->string('july_nps', 15);
            $table->string('aug_feed', 15);
            $table->string('aug_q', 15);
            $table->string('aug_fcr', 15);
            $table->string('aug_crr', 15);
            $table->string('aug_nps', 15);
            $table->string('sept_feed', 15);
            $table->string('sept_q', 15);
            $table->string('sept_fcr', 15);
            $table->string('sept_crr', 15);
            $table->string('sept_nps', 15);
            $table->string('oct_feed', 15);
            $table->string('oct_q', 15);
            $table->string('oct_fcr', 15);
            $table->string('oct_crr', 15);
            $table->string('oct_nps', 15);
            $table->string('nov_feed', 15);
            $table->string('nov_q', 15);
            $table->string('nov_fcr', 15);
            $table->string('nov_crr', 15);
            $table->string('nov_nps', 15);
            $table->string('dec_feed', 15);
            $table->string('dec_q', 15);
            $table->string('dec_fcr', 15);
            $table->string('dec_crr', 15);
            $table->string('dec_nps', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('agent_CQN');
    }

}
