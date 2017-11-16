<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatasourceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datasource', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tid')->index();
            $table->enum('type', ['cases', 'quality', 'sas', 'cosmo'])->default('cases');
            $table->enum('status', ['fetched', 'processed'])->default('fetched');
            $table->string('filepath');
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
        Schema::drop('datasource');
    }

}
