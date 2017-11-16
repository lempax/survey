<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMrformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mr_forms', function (Blueprint $table) {
            $table->integer('id');
            $table->text('contents');
            $table->text('reasons');
            $table->text('department');
            $table->smallInteger('next_approval');
            $table->integer('requested_by');
            $table->integer('quoted_by');
            $table->integer('date_quoted');
            $table->integer('dept_head');
            $table->integer('sga_admin');
            $table->integer('sga_manager');
            $table->enum('status', ['pending', 'approved', 'disapproved']);
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
        Schema::drop('mr_forms');
    }
}
