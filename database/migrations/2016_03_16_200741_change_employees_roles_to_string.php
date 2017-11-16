<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEmployeesRolesToString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE employees CHANGE roles roles VARCHAR(50) NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE employees CHANGE roles roles ENUM('manager','som','supervisor','agent','l2','it','hr') NOT NULL DEFAULT 'agent'");
    }
}
