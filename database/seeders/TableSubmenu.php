<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSubmenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submenu')->insert(

            array (
                0 => array (
                    'menu_id' => 1,
                    'menu_utama_id' => 1, 
                    'nama_submenu' => 'Profil', 
                    'url_submenu' => 'akun/profil',
                    'ikon_submenu' => 'fas fa-fw fa-user',
                    'status_submenu' => 1,

                ),
                1 => array (
                    'menu_id' => 2,
                    'menu_utama_id' => 2, 
                    'nama_submenu' => 'Dashboard Masuk', 
                    'url_submenu' => 'beranda/dashboard_masuk',
                    'ikon_submenu' => 'fas fa-fw fa-tachomater-alt',
                    'status_submenu' => 1,

                ),
                2 => array (
                    'menu_id' => 5,
                    'menu_utama_id' => 11, 
                    'nama_submenu' => 'Menu', 
                    'url_submenu' => 'pengaturan/menu',
                    'ikon_submenu' => 'fas fa-fw fa-folder',
                    'status_submenu' => 1,

                ),
                3 => array (
                    'menu_id' => 5,
                    'menu_utama_id' => 11, 
                    'nama_submenu' => 'Submenu', 
                    'url_submenu' => 'pengaturan/submenu',
                    'ikon_submenu' => 'fas fa-fw fa-folder-open',
                    'status_submenu' => 1,
                ),
                4 => array (
                    'menu_id' => 5,
                    'menu_utama_id' => 10, 
                    'nama_submenu' => 'Role', 
                    'url_submenu' => 'pengaturan/role',
                    'ikon_submenu' => 'fas fa-fw fa-user-cog',
                    'status_submenu' => 1,
                ),
                5 => array (
                    'menu_id' => 1,
                    'menu_utama_id' => 1, 
                    'nama_submenu' => 'Ubah Sandi', 
                    'url_submenu' => 'akun/sandi',
                    'ikon_submenu' => 'fas fa-fw fa-user-lock',
                    'status_submenu' => 1,
                ),
                6 => array (
                    'menu_id' => 3,
                    'menu_utama_id' => 3, 
                    'nama_submenu' => 'Daftar Barang', 
                    'url_submenu' => 'suplai/barang',
                    'ikon_submenu' => 'fas fa-fw fa-boxes',
                    'status_submenu' => 1,
                ),
                7 => array (
                    'menu_id' => 3,
                    'menu_utama_id' => 3, 
                    'nama_submenu' => 'Daftar Satuan', 
                    'url_submenu' => 'suplai/satuan',
                    'ikon_submenu' => 'fas fa-fw fa-wine-bottle',
                    'status_submenu' => 1,
                ),
                8 => array (
                    'menu_id' => 3,
                    'menu_utama_id' => 3, 
                    'nama_submenu' => 'Daftar Kategori', 
                    'url_submenu' => 'suplai/kategori',
                    'ikon_submenu' => 'fas fa-fw fa-tag',
                    'status_submenu' => 1,

                ),
                9 => array (
                    'menu_id' => 3,
                    'menu_utama_id' => 3, 
                    'nama_submenu' => 'Daftar Merek', 
                    'url_submenu' => 'suplai/merek',
                    'ikon_submenu' => 'fas fa-fw fa-list-alt',
                    'status_submenu' => 1,
                ),
                10 => array (
                    'menu_id' => 5,
                    'menu_utama_id' => 12, 
                    'nama_submenu' => 'Kode Barang', 
                    'url_submenu' => 'pengaturan/kode/barang',
                    'ikon_submenu' => 'fas fa-fw fa-keyboard',
                    'status_submenu' => 1,

                ),
                11 => array (
                    'menu_id' => 7,
                    'menu_utama_id' => 15, 
                    'nama_submenu' => 'Daftar Karyawan', 
                    'url_submenu' => 'tempat/karyawan',
                    'ikon_submenu' => 'fas fa-fw fa-users',
                    'status_submenu' => 1,
                ),
                12 => array (
                    'menu_id' => 5,
                    'menu_utama_id' => 13, 
                    'nama_submenu' => 'Pengaturan Stok', 
                    'url_submenu' => 'pengaturan/stok',
                    'ikon_submenu' => 'fas fa-fw fa-dolly-flatbed',
                    'status_submenu' => 1,
                ),
                13 => array (
                    'menu_id' => 5,
                    'menu_utama_id' => 12, 
                    'nama_submenu' => 'Kode Transaksi', 
                    'url_submenu' => 'pengaturan/kode/transaksi',
                    'ikon_submenu' => 'fas fa-fw fa-keyboard',
                    'status_submenu' => 1,
                ),
                14 => array (
                    'menu_id' => 7,
                    'menu_utama_id' => 14, 
                    'nama_submenu' => 'Profil Toko', 
                    'url_submenu' => 'tempat/toko',
                    'ikon_submenu' => 'fas fa-fw fa-store-alt',
                    'status_submenu' => 1,
                ),
                15 => array (
                    'menu_id' => 6,
                    'menu_utama_id' => 4, 
                    'nama_submenu' => 'Kasir', 
                    'url_submenu' => 'fitur/kasir',
                    'ikon_submenu' => 'fas fa-fw fa-cash-register',
                    'status_submenu' => 1,
                ),
                16 => array (
                    'menu_id' => 4,
                    'menu_utama_id' => 6, 
                    'nama_submenu' => 'Laporan Masuk', 
                    'url_submenu' => 'laporan/masuk/cari',
                    'ikon_submenu' => 'fas fa-fw fa-calendar-alt',
                    'status_submenu' => 1,

                ),
                17 => array (
                    'menu_id' => 4,
                    'menu_utama_id' => 7, 
                    'nama_submenu' => 'Laporan Keluar', 
                    'url_submenu' => 'laporan/keluar/cari',
                    'ikon_submenu' => 'fas fa-fw fa-clipboard',
                    'status_submenu' => 1,

                ),
                18 => array (
                    'menu_id' => 6,
                    'menu_utama_id' => 5, 
                    'nama_submenu' => 'Barang Masuk', 
                    'url_submenu' => 'fitur/barang/masuk',
                    'ikon_submenu' => 'fas fa-fw fa-file-signature',
                    'status_submenu' => 1,

                ),
                19 => array (
                    'menu_id' => 4,
                    'menu_utama_id' => 9, 
                    'nama_submenu' => 'Summary Tanggal', 
                    'url_submenu' => 'laporan/summary/tanggal',
                    'ikon_submenu' => 'fas fa-fw fa-list-ol',
                    'status_submenu' => 1,

                ),
                20 => array (
                    'menu_id' => 4,
                    'menu_utama_id' => 9, 
                    'nama_submenu' => 'Summary Bulan', 
                    'url_submenu' => 'laporan/summary/bulan',
                    'ikon_submenu' => 'fas fa-fw fa-list-ul',
                    'status_submenu' => 1,

                ),
                21 => array (
                    'menu_id' => 4,
                    'menu_utama_id' => 9, 
                    'nama_submenu' => 'Summary Tahun', 
                    'url_submenu' => 'laporan/summary/tahun',
                    'ikon_submenu' => 'fas fa-fw fa-list',
                    'status_submenu' => 1,

                ),
                22 => array (
                    'menu_id' => 2,
                    'menu_utama_id' => 2, 
                    'nama_submenu' => 'Dashboard Keluar', 
                    'url_submenu' => 'beranda/dashboard_keluar',
                    'ikon_submenu' => 'fas fa-fw fa-tachometer-alt',
                    'status_submenu' => 1,

                ),
                23 => array (
                    'menu_id' => 6,
                    'menu_utama_id' => 4, 
                    'nama_submenu' => 'Daftar Utang', 
                    'url_submenu' => 'fitur/utang',
                    'ikon_submenu' => 'fas fa-fw fa-credit-card',
                    'status_submenu' => 1,

                ),
                24 => array (
                    'menu_id' => 3,
                    'menu_utama_id' => 3, 
                    'nama_submenu' => 'Daftar Supplier', 
                    'url_submenu' => 'suplai/supplier',
                    'ikon_submenu' => 'fas fa-fw fa-users',
                    'status_submenu' => 1,

                ),
                25 => array (
                    'menu_id' => 5,
                    'menu_utama_id' => 11, 
                    'nama_submenu' => 'Menu Utama', 
                    'url_submenu' => 'pengaturan/menu_utama',
                    'ikon_submenu' => 'far fa-fw fa-folder',
                    'status_submenu' => 1,

                ),
              
            )
        );
    }
}
