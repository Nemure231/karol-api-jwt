<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu')->insert(

            array (
                0 => array ('nama_menu' => 'Akun'),
                1 => array ('nama_menu' => 'Bendahara'),
                2 => array ('nama_menu' => 'Suplai'),
                3 => array ('nama_menu' => 'Laporan'),
                4 => array ('nama_menu' => 'Pengaturan'),
                5 => array ('nama_menu' => 'Fitur'),
                6 => array ('nama_menu' => 'Tempat')
               
            )
        );
    }
}
