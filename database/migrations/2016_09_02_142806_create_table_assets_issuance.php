<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAssetsIssuance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_issuance', function (Blueprint $table) {
            $table->integer('issued_id');
            $table->integer('issued_by');
            $table->integer('issued_to');
            $table->text('department');
            $table->text('purpose');
            $table->date('date_issued');
            $table->integer('prepared_by');
            $table->integer('approved_by');
            $table->text('status');
            $table->text('remarks');
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
         Schema::drop('assets_issuance');
    }
}
