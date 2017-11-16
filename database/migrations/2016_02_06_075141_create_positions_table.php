<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('positions', function (Blueprint $table) {
            $table->integer('uid');
            $table->enum('position', ['manager', 'som', 'supervisor', 'agent', 'it', 'hr'])->default('agent');
            $table->timestamps();
            $table->primary('uid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('positions');
    }

}
