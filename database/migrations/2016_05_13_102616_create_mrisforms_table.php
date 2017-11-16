<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMrisformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mris_forms', function (Blueprint $table) {
            $table->integer('id');
            $table->text('contents');
            $table->text('reasons');
            $table->text('department');
            $table->integer('next_approval');
            $table->integer('requested_by');
            $table->integer('quoted_by');
            $table->integer('date_quoted');
            $table->integer('dept_head');
            $table->integer('sga_admin');
            $table->integer('sga_manager');
            $table->text('status');
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
        Schema::drop('mris_forms');
    }
}
