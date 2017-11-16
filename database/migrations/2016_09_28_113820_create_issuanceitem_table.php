<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuanceitemTable extends Migration
{
    public function up()
    {
        Schema::create('issuanceitem', function (Blueprint $table) {
	    $table->integer('issued_id');
            $table->integer('issued_by');
            $table->integer('issued_to');
            $table->integer('attached_mris');
            $table->integer('attached_iris');
            $table->text('department');
            $table->text('purpose');
            $table->timestamps();          
        });
    }

    public function down()
    {
        Schema::drop('issuanceitem');
    }
}
