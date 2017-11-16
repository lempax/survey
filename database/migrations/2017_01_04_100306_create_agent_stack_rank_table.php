<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentStackRankTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('agent_stack_rank', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rid', 15);
            $table->string('agent', 15);
            $table->string('team', 15);
            $table->string('jan_cr', 15);
            $table->string('jan_feed', 15);
            $table->string('feb_cr', 15);
            $table->string('feb_feed', 15);
            $table->string('mar_cr', 15);
            $table->string('mar_feed', 15);
            $table->string('april_cr', 15);
            $table->string('april_feed', 15);
            $table->string('may_cr', 15);
            $table->string('may_feed', 15);
            $table->string('june_cr', 15);
            $table->string('june_feed', 15);
            $table->string('july_cr', 15);
            $table->string('july_feed', 15);
            $table->string('aug_cr', 15);
            $table->string('aug_feed', 15);
            $table->string('sept_cr', 15);
            $table->string('sept_feed', 15);
            $table->string('oct_cr', 15);
            $table->string('oct_feed', 15);
            $table->string('nov_cr', 15);
            $table->string('nov_feed', 15);
            $table->string('dec_cr', 15);
            $table->string('dec_feed', 15);
            $table->string('ave_cr', 15);
            $table->string('rank_cr', 15);
            $table->string('jan_q', 15);
            $table->string('feb_q', 15);
            $table->string('mar_q', 15);
            $table->string('april_q', 15);
            $table->string('may_q', 15);
            $table->string('june_q', 15);
            $table->string('july_q', 15);
            $table->string('aug_q', 15);
            $table->string('sept_q', 15);
            $table->string('oct_q', 15);
            $table->string('nov_q', 15);
            $table->string('dec_q', 15);
            $table->string('ave_q', 15);
            $table->string('rank_q', 15);
            $table->string('jan_nps', 15);
            $table->string('feb_nps', 15);
            $table->string('mar_nps', 15);
            $table->string('april_nps', 15);
            $table->string('may_nps', 15);
            $table->string('june_nps', 15);
            $table->string('july_nps', 15);
            $table->string('aug_nps', 15);
            $table->string('sept_nps', 15);
            $table->string('oct_nps', 15);
            $table->string('nov_nps', 15);
            $table->string('dec_nps', 15);
            $table->string('ave_nps', 15);
            $table->string('rank_nps', 15);
            $table->string('jan_prod', 15);
            $table->string('feb_prod', 15);
            $table->string('mar_prod', 15);
            $table->string('april_prod', 15);
            $table->string('may_prod', 15);
            $table->string('june_prod', 15);
            $table->string('july_prod', 15);
            $table->string('aug_prod', 15);
            $table->string('sept_prod', 15);
            $table->string('oct_prod', 15);
            $table->string('nov_prod', 15);
            $table->string('dec_prod', 15);
            $table->string('ave_prod', 15);
            $table->string('rank_prod', 15);
            $table->string('jan_sas', 15);
            $table->string('feb_sas', 15);
            $table->string('mar_sas', 15);
            $table->string('april_sas', 15);
            $table->string('may_sas', 15);
            $table->string('june_sas', 15);
            $table->string('july_sas', 15);
            $table->string('aug_sas', 15);
            $table->string('sept_sas', 15);
            $table->string('oct_sas', 15);
            $table->string('nov_sas', 15);
            $table->string('dec_sas', 15);
            $table->string('ave_sas', 15);
            $table->string('rank_sas', 15);
            $table->string('jan_rel', 15);
            $table->string('feb_rel', 15);
            $table->string('mar_rel', 15);
            $table->string('april_rel', 15);
            $table->string('may_rel', 15);
            $table->string('june_rel', 15);
            $table->string('july_rel', 15);
            $table->string('aug_rel', 15);
            $table->string('sept_rel', 15);
            $table->string('oct_rel', 15);
            $table->string('nov_rel', 15);
            $table->string('dec_rel', 15);
            $table->string('ave_rel', 15);
            $table->string('rank_rel', 15);
            $table->string('jan_aht', 15);
            $table->string('feb_aht', 15);
            $table->string('mar_aht', 15);
            $table->string('april_aht', 15);
            $table->string('may_aht', 15);
            $table->string('june_aht', 15);
            $table->string('july_aht', 15);
            $table->string('aug_aht', 15);
            $table->string('sept_aht', 15);
            $table->string('oct_aht', 15);
            $table->string('nov_aht', 15);
            $table->string('dec_aht', 15);
            $table->string('ave_aht', 15);
            $table->string('rank_aht', 15);
            $table->string('total', 15);
            $table->string('overall', 15);
            $table->string('logged_by', 15);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('agent_stack_rank');
    }

}
