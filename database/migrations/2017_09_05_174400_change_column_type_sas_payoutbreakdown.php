<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypeSasPayoutbreakdown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sas_payout_breakdown', function (Blueprint $table) {
            $table->string('payout_cycle', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sas_payout_breakdown', function (Blueprint $table) {
            $table->date('payout_cycle')->change();
        });
    }
}
