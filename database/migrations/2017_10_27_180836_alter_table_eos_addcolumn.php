<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEosAddcolumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('eos', function (Blueprint $table) {
              $table->text('fin_impact');
              $table->text('challenges');
              $table->text('shift_highlight');
              $table->text('shift_lowlight');
              $table->string('start_no_tickets');
              $table->string('end_no_tickets');
                                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eos', function (Blueprint $table) {
            $table->dropColumn('fin_impact');
            $table->dropColumn('challenges');
            $table->dropColumn('shift_highlight');
            $table->dropColumn('shift_lowlight');
            $table->dropColumn('start_no_tickets');
            $table->dropColumn('end_no_tickets');
            
        });
    }
}
