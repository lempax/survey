<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasPayoutBreakdownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_payout_breakdown', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid');
            $table->string('team', 50);
            $table->string('agent', 50);
            $table->date('payout_cycle');
            $table->integer('contract_id');
            $table->text('product');
            $table->integer('upsell');
            $table->integer('logged_by');
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
        Schema::drop('sas_payout_breakdown');
    }
}
