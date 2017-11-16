<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaslowperformerscasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saslowperformerscases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_name');
            $table->integer('agent_name');
            $table->integer('total_calls');
            $table->text('reasons');
            $table->text('sup_actionplan');
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
        Schema::drop('saslowperformerscases');
    }
}
