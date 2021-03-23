<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

//eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYxNDMyMTE1MiwiZXhwIjoxNjE0MzI0NzUyLCJuYmYiOjE2MTQzMjExNTIsImp0aSI6IkpTdG1Ickw2a3lPZTNmN3EiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.BnDofwMQgM4ekrfkrHvHdSZ8rqtTmPZqBGK1-6P_Kq0

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function () use ($router){

    $router->group(['prefix' => 'auth'], function () use ($router){

        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->get('ambil_token', 'AuthController@ambil_token');
        $router->get('me', 'AuthController@me');
    });

    $router->group(['prefix' => 'akun'], function () use ($router){
        $router->group(['prefix' => 'profil'], function () use ($router){
            $router->get('{id}', 'UserController@ambilSatuUser');
            $router->get('untuk-profil/{id}', 'UserController@ambilSatuUserUntukProfil');
            $router->get('dengan-role/{id}', 'UserController@ambilSatuUserJoinRole');
            $router->put('ubah/{id}', 'UserController@ubahUser');
        });

        $router->group(['prefix' => 'sandi'], function () use ($router){
            $router->get('{id}', 'UserController@ambilSatuSandi');
            $router->put('ubah/{id}', 'UserController@ubahSandi');
        });
    });


    $router->group(['prefix' => 'pengaturan'], function () use ($router){
        $router->group(['prefix' => 'menu'], function () use ($router){
            $router->get('untuk-sidebar/{id}', 'MenuController@ambilMenuUntukSidebar');
            $router->get('untuk-role-akses', 'MenuController@ambilMenuUntukDaftarRoleAkses');
            $router->get('', 'MenuController@ambilMenu');
            $router->post('tambah', 'MenuController@tambahMenu');
            $router->put('ubah/{id}', 'MenuController@ubahMenu');
            $router->delete('hapus/{id}', 'MenuController@hapusMenu');
        });

        $router->group(['prefix' => 'menu_utama'], function () use ($router){
            $router->get('untuk-sidebar/{id}', 'MenuUtamaController@ambilMenuUtamaUntukSidebar');
            $router->get('', 'MenuUtamaController@ambilMenuUtamaJoinMenu');
            $router->get('untuk-submenu', 'MenuUtamaController@ambilMenuUtamaUntukSubmenu');
            $router->post('tambah', 'MenuUtamaController@tambahMenuUtama');
            $router->put('ubah/{id}', 'MenuUtamaController@ubahMenuUtama');
            $router->delete('hapus/{id}', 'MenuUtamaController@hapusMenuUtama');
        });
        
        $router->group(['prefix' => 'submenu'], function () use ($router){
            $router->get('untuk-sidebar/{menu_id}/{menu_utama_id}', 'SubmenuController@ambilSubmenuUntukSidebar');
            $router->get('', 'SubmenuController@ambilSubmenu');
            $router->post('tambah', 'SubmenuController@tambahSubmenu');
            $router->put('ubah/{id}', 'SubmenuController@ubahSubmenu');
            $router->delete('hapus/{id}', 'SubmenuController@hapusSubmenu');
        });


        $router->group(['prefix' => 'role'], function () use ($router){
            $router->get('', 'RoleController@ambilRole');
            $router->post('tambah', 'RoleController@tambahRole');
            $router->put('ubah/{id}', 'RoleController@ubahRole');
            $router->delete('hapus/{id}', 'RoleController@hapusRole');
            $router->get('cek-centang/{id}', 'RoleController@ambilRoleUntukCekCentangAksesRole');


            $router->get('akses/cek-centang/{role_id}/{menu_id}', 'AksesRoleController@cekCentangAksesRole');
            $router->post('akses/ubah/{id_role}/{id_menu}', 'AksesRoleController@ubahAksesRole');
            $router->get('akses/cek-akses/{role_id}/{uri_menu}', 'AksesRoleController@cekAksesUser');

        });

    });

    $router->group(['prefix' => 'suplai'], function () use ($router){

        $router->group(['prefix' => 'barang'], function () use ($router){
            $router->get('', 'BarangController@ambilBarang');
            $router->post('tambah', 'BarangController@tambahBarang');
            $router->put('ubah/{id}', 'BarangController@ubahBarang');
            $router->delete('hapus/{id}', 'BarangController@hapusBarang');

        });

        $router->group(['prefix' => 'kategori'], function () use ($router){
            $router->get('', 'KategoriController@ambilKategori');
            $router->post('tambah', 'KategoriController@tambahKategori');
            $router->put('ubah/{id}', 'KategoriController@ubahKategori');
            $router->delete('hapus/{id}', 'KategoriController@hapusKategori');

        });

        $router->group(['prefix' => 'satuan'], function () use ($router){
            $router->get('', 'SatuanController@ambilSatuan');
            $router->post('tambah', 'SatuanController@tambahSatuan');
            $router->put('ubah/{id}', 'SatuanController@ubahSatuan');
            $router->delete('hapus/{id}', 'SatuanController@hapusSatuan');

        });

        $router->group(['prefix' => 'merek'], function () use ($router){
            $router->get('', 'MerekController@ambilMerek');
            $router->post('tambah', 'MerekController@tambahMerek');
            $router->put('ubah/{id}', 'MerekController@ubahMerek');
            $router->delete('hapus/{id}', 'MerekController@hapusMerek');

        });

        $router->group(['prefix' => 'supplier'], function () use ($router){
            $router->get('', 'SupplierController@ambilSupplier');
            $router->post('tambah', 'SupplierController@tambahSupplier');
            $router->put('ubah/{id}', 'SupplierController@ubahSupplier');
            $router->delete('hapus/{id}', 'SupplierController@hapusSupplier');

        });
    });



});
