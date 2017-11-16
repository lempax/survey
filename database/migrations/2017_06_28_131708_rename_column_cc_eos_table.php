<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnCcEosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eos', function (Blueprint $table) {
             $table->renameColumn('tasks', 'cc');
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
            $table->renameColumn('cc', 'tasks');
        });
    }
}
