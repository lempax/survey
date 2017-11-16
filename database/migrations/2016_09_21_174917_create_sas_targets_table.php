<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasTargetsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sas_targets', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('logged_by');
            $table->integer('departmentid');
            $table->integer('month');
            $table->integer('year');
            $table->integer('target');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sas_targets');
    }

}
