<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAssetsIssuanceItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('assets_issuance_item', function (Blueprint $table) {
            $table->integer('issued_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->text('serial');
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
        Schema::drop('assets_issuance_item');
    }
}
