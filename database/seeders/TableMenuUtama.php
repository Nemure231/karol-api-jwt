<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableMenuUtama extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_utama')->insert(

            array (
                0 => array ('menu_id' => 1, 'nama_menu_utama' => 'Profil', 'ikon_menu_utama' => 'fas fa-fw fa-user'),
                1 => array ('menu_id' => 2, 'nama_menu_utama' => 'Dashboard', 'ikon_menu_utama' => 'fas fa-fw fa-tachometer-alt'),
                2 => array ('menu_id' => 3, 'nama_menu_utama' => 'Gudang', 'ikon_menu_utama' => 'fas fa-fw fa-warehouse'),
                3 => array ('menu_id' => 6, 'nama_menu_utama' => 'Penjualan', 'ikon_menu_utama' => 'fas fa-fw fa-shopping-cart'),
                4 => array ('menu_id' => 6, 'nama_menu_utama' => 'Pembelian', 'ikon_menu_utama' => 'fas fa-fw fa-cart-plus'),
                5 => array ('menu_id' => 4, 'nama_menu_utama' => 'Barang Masuk', 'ikon_menu_utama' => 'fas fa-fw fa-truck loading'),
                6 => array ('menu_id' => 4, 'nama_menu_utama' => 'Barang Keluar', 'ikon_menu_utama' => 'fas fa-fw fa-box-open'),
                7 => array ('menu_id' => 4, 'nama_menu_utama' => 'Summary', 'ikon_menu_utama' => 'fas fa-fw fa-th-list'),
                8 => array ('menu_id' => 5, 'nama_menu_utama' => 'Role', 'ikon_menu_utama' => 'fas fa-fw fa-cogs'),
                9 => array ('menu_id' => 5, 'nama_menu_utama' => 'Menu', 'ikon_menu_utama' => 'fas fa-fw fa-bars'),
                10 => array ('menu_id' =>5, 'nama_menu_utama' => 'Kode', 'ikon_menu_utama' => 'fas fa-fw fa-code'),
                11 => array ('menu_id' =>5, 'nama_menu_utama' => 'Stok', 'ikon_menu_utama' => 'fas fa-fw fa-sort-numeric-up'),
                12 => array ('menu_id' =>7, 'nama_menu_utama' => 'Toko', 'ikon_menu_utama' => 'fas fa-fw fa-store'),
                13 => array ('menu_id' =>7, 'nama_menu_utama' => 'Karyawan', 'ikon_menu_utama' => 'fas fa-fw fa-users')
               
            )
        );
    }
}
