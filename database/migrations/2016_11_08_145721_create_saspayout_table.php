<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaspayoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sas_payout', function(Blueprint $table){
            $table->increments('id');
            $table->string('month', 15);
            $table->integer('sales_date');
            $table->integer('cw');
            $table->integer('contract_id');
            $table->integer('customer_id');
            $table->integer('person_id');
            $table->text('fname');
            $table->text('lname');
            $table->integer('product_id');
            $table->text('product_desc');
            $table->text('prev_product_id');
            $table->text('prev_product_desc');
            $table->text('tc_value');
            $table->text('upside_down', 15);
            $table->string('country', 10);
            $table->string('cd_team_id', 10);
            $table->text('service_provider');
            $table->string('location', 5);
            $table->string('mc_check', 10);
            $table->string('ops_sales_cluster', 30);
            $table->string('ops_sales_cluster_compact', 30);
            $table->string('transaction', 5);
            $table->text('department', 30);
            $table->integer('upsells');
            $table->string('full_name', 50);
            $table->string('remarks', 20);
            $table->text('comments');
            $table->float('product_price');
            $table->text('invoice');
            $table->text('logged_by');
            $table->date('validation_date');
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
        Schema::drop('sas_payout');
    }
}
