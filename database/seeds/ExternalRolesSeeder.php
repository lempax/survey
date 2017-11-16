<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExternalRolesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('external_roles')->insert([
            'uid' => 21386671,
            'role' => 'L2',
            'added_by' => 21386675,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('external_roles')->insert([
            'uid' => 21390893,
            'role' => 'L2',
            'added_by' => 21386675,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('external_roles')->insert([
            'uid' => 21402092,
            'role' => 'L2',
            'added_by' => 21386675,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('external_roles')->insert([
            'uid' => 21271004,
            'role' => 'L2',
            'added_by' => 21386675,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        DB::table('external_roles')->insert([
            'uid' => 21435876,
            'role' => 'L2',
            'added_by' => 21386675,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
    }

}
