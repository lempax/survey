<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSasTrackingTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->date('sales_date')->index();
            $table->string('cw', 10);
            $table->integer('contract_id');
            $table->integer('customer_id');
            $table->integer('person_id')->index();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->integer('product_id');
            $table->string('product_desc', 100);
            $table->integer('previous_product_id');
            $table->string('previous_product_desc', 100);
            $table->string('tc_value', 20);
            $table->string('up_side_down', 50);
            $table->enum('country', ['US', 'UK'])->default('US');
            $table->string('cd_team_id', 10);
            $table->string('serviceprovider', 10);
            $table->string('location', 10);
            $table->string('mc_check', 20);
            $table->string('ops_sales_cluster', 50);
            $table->string('ops_sales_cluster_compact', 50);
            $table->string('transaction', 10);
            $table->string('department', 50);
            $table->tinyInteger('net');
            $table->string('sac', 10)->nullable();
            $table->string('bulk', 10)->nullable();
            $table->integer('tid')->index();
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
        Schema::drop('sas_tracking');
    }

}
