<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBdateToEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->date('bdate')->default('0000-00-00')->after('email');
            $table->date('hiredate')->default('0000-00-00')->after('bdate');
            $table->string('companyid', 15)->nullable()->after('hiredate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('bdate');
            $table->dropColumn('hiredate');
            $table->dropColumn('companyid');
        });
    }
}
