<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('uid')->primary();
            $table->integer('departmentid');
            $table->string('username', 50);
            $table->string('password');
            $table->string('lname', 50);
            $table->string('fname', 50);
            $table->string('email', 100);
            $table->enum('roles', ['manager', 'som', 'supervisor', 'agent', 'l2', 'it', 'hr'])->default('agent');
            $table->tinyInteger('active')->default(1);
            $table->rememberToken();
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
        Schema::drop('employees');
    }
}
