<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableQuestionModifyColumnQuestionType extends Migration
{
    /**
     * Run the migrations.
     *\DB::statement("ALTER TABLE employees CHANGE roles roles VARCHAR(50) NOT NULL");
     * @return void
     */
    public function up()
    {
      Schema::table('question', function (Blueprint $table) {
            $table->string('question_type', 500)->change();
        });
      Schema::table('question', function (Blueprint $table) {
            $table->string('option_name', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
