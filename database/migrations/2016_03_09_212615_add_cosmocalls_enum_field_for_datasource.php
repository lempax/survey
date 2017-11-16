<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCosmocallsEnumFieldForDatasource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datasource', function (Blueprint $table) {
            \DB::statement("ALTER TABLE datasource CHANGE type type ENUM('cases','quality','sas','cosmo','cosmocalls') NOT NULL DEFAULT 'cases'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datasource', function (Blueprint $table) {
            \DB::statement("ALTER TABLE datasource CHANGE type type ENUM('cases','quality','sas','cosmo') NOT NULL DEFAULT 'cases'");
        });
    }
}
