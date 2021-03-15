<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableAksesMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('akses_menu')->insert(

            array (
                0 => array ('menu_id' => 1, 'role_id' => 1),
                1 => array ('menu_id' => 2, 'role_id' => 1),
                2 => array ('menu_id' => 3, 'role_id' => 1),
                3 => array ('menu_id' => 4, 'role_id' => 1),
                4 => array ('menu_id' => 5, 'role_id' => 1),
                5 => array ('menu_id' => 6, 'role_id' => 1),
                6 => array ('menu_id' => 7, 'role_id' => 1)
               
            )
        );
    }
}
