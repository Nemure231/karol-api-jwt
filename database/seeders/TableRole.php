<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert(

            array (
                0 => array ('nama_role' => 'Admin'),
                1 => array ('nama_role' => 'Bendahara'),
                2 => array ('nama_role' => 'Kasir'),
                3 => array ('nama_role' => 'Konsumen'),
                4 => array ('nama_role' => 'Anggota'),
                5 => array ('nama_role' => 'Gudang'),
               
            )
        );

            


        
    }
}
