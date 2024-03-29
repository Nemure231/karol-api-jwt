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
    // return $router->app->version();
    return '
    <!DOCTYPE html>
    <html>
    <head>
    <style>
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
    </style>
    </head>
    <body>
    Tangkap data pada endpoint menggunakan aplikasi postman
    <table style="width:100%">
      <tr>
        <th rowspan="3">Method</th>
        <th rowspan="3">EndPoints</th>
        <th colspan="2" rowspan="2">Form</th>
        <th rowspan="3">Usage</th>
      </tr>
      <tr>
      </tr>
      <tr>
          <th>Key</th>
        <th>Bearer token</th>
      </tr>
      <tr>
          <td rowspan="4">POST</td>
        <td rowspan="4">/api/auth/register</td>
        <td>name</td>
        <td rowspan="4">No</td>
        <td rowspan="4">Untuk registrasi</td>
      </tr>
      <tr>
        <td>email</td>
      </tr>
      <tr>
       
        <td>password</td>
      </tr>
      <tr>
      
        <td>password_confirmation</td>
      </tr>
      
      
      <tr>
          <td rowspan="2">POST</td>
        <td rowspan="2">/api/auth/login</td>
        <td>email</td>
        <td rowspan="2">No</td>
        <td rowspan="2">Untuk login dan mendapatkan token</td>
      </tr>
      <tr>
        <td>password</td>
      </tr>
      
      
       <tr>
          <td rowspan="1">GET</td>
        <td rowspan="1">/api/auth/me</td>
        <td></td>
        <td rowspan="1">Yes</td>
        <td rowspan="1">Mendapatkan informasi Anda</td>
      </tr>
      
       <tr>
          <td rowspan="1">POST</td>
        <td rowspan="1">/api/auth/logout</td>
        <td></td>
        <td rowspan="1">Yes</td>
        <td rowspan="1">Untuk keluar dari akun</td>
      </tr>
      
      
      
       <tr>
          <td rowspan="3">PUT</td>
        <td rowspan="3">/api/profil/{id}</td>
        <td>name</td>
        <td rowspan="3">Yes</td>
        <td rowspan="3">Mengubah user, parameter {id} pada Endpoint dapat dilihat saat Anda melihat informasi akun Anda.</td>
      </tr>
      <tr>
        <td>telepon</td>
      </tr>
      <tr>
       
        <td>alamat</td>
      </tr>
      
     
     
     
     
     <tr>
          <td rowspan="3">PUT</td>
        <td rowspan="3">/api/sandi/{id}</td>
        <td>password_lama</td>
        <td rowspan="3">Yes</td>
        <td rowspan="3">Mengubah sandi, parameter {id} pada Endpoint dapat dilihat saat Anda melihat informasi akun Anda. Key password_lama adalah sandi sebelumnya yang harus anda input, sedangkan password sandi baru anda.</td>
      </tr>
      <tr>
        <td>password</td>
      </tr>
      <tr>
       
        <td>password_confirmation</td>
      </tr>
     
     
      
     
     
    </table>
    </body>
    </html>
    
    
    
    ';
});


$router->group(['prefix' => 'api'], function () use ($router){

    $router->group(['prefix' => 'auth'], function () use ($router){

        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->get('ambil_token', 'AuthController@ambil_token');
        $router->get('me', 'AuthController@me');
    });

        $router->group(['prefix' => 'profil'], function () use ($router){
            $router->get('{id}', 'UserController@ambilSatuUser');
            $router->put('{id}', 'UserController@ubahUser');
            
            $router->get('untuk-profil/{id}', 'UserController@ambilSatuUserUntukProfil');
            $router->get('dengan-role/{id}', 'UserController@ambilSatuUserJoinRole');
        });

        $router->group(['prefix' => 'sandi'], function () use ($router){
            $router->get('{id}', 'UserController@ambilSatuSandi');
            $router->put('{id}', 'UserController@ubahSandi');
        });




        $router->group(['prefix' => 'menu'], function () use ($router){
            $router->get('untuk-sidebar/{id}', 'MenuController@ambilMenuUntukSidebar');
            $router->get('untuk-role-akses', 'MenuController@ambilMenuUntukDaftarRoleAkses');
            
            $router->get('', 'MenuController@ambilMenu');
            $router->post('', 'MenuController@tambahMenu');
            $router->put('{id}', 'MenuController@ubahMenu');
            $router->delete('{id}', 'MenuController@hapusMenu');
        });

        $router->group(['prefix' => 'menu_utama'], function () use ($router){
            $router->get('untuk-sidebar/{id}', 'MenuUtamaController@ambilMenuUtamaUntukSidebar');
            $router->get('untuk-submenu', 'MenuUtamaController@ambilMenuUtamaUntukSubmenu');
            $router->get('', 'MenuUtamaController@ambilMenuUtamaJoinMenu');
            $router->post('', 'MenuUtamaController@tambahMenuUtama');
            $router->put('{id}', 'MenuUtamaController@ubahMenuUtama');
            $router->delete('{id}', 'MenuUtamaController@hapusMenuUtama');
        });
        
        $router->group(['prefix' => 'submenu'], function () use ($router){
            $router->get('untuk-sidebar/{menu_id}/{menu_utama_id}', 'SubmenuController@ambilSubmenuUntukSidebar');
            $router->get('', 'SubmenuController@ambilSubmenu');
            $router->post('', 'SubmenuController@tambahSubmenu');
            $router->put('{id}', 'SubmenuController@ubahSubmenu');
            $router->delete('{id}', 'SubmenuController@hapusSubmenu');
        });

    $router->group(['prefix' => 'role'], function () use ($router){
        $router->get('', 'RoleController@ambilRole');
        $router->post('', 'RoleController@tambahRole');
        $router->put('{id}', 'RoleController@ubahRole');
        $router->delete('{id}', 'RoleController@hapusRole');
        $router->get('cek-centang/{id}', 'RoleController@ambilRoleUntukCekCentangAksesRole');

        $router->post('akses', 'AksesRoleController@ubahAksesRole');
        $router->get('akses/cek-centang/{role_id}/{menu_id}', 'AksesRoleController@cekCentangAksesRole');
        $router->get('akses/cek-akses/{role_id}/{uri_menu}', 'AksesRoleController@cekAksesUser');

    });

    

        $router->group(['prefix' => 'stok'], function () use ($router){
            $router->get('cari/{min_stok}', 'StokController@cariStok');

        });

        $router->group(['prefix' => 'barang'], function () use ($router){
            $router->get('', 'BarangController@ambilBarang');
            $router->post('', 'BarangController@tambahBarang');
            $router->put('{id}', 'BarangController@ubahBarang');
            $router->delete('{id}', 'BarangController@hapusBarang');

        });

        $router->group(['prefix' => 'barang_masuk'], function () use ($router){
            $router->get('untuk-barang-masuk', 'BarangMasukController@ambilBarangUntukBarangMasuk');
            $router->get('ambil-barang-dan-supplier', 'BarangMasukController@ambilDetailBarangDanSupplier');
            $router->get('ambil-harga/{id}', 'BarangMasukController@ambilHargaUntukBarangMasuk');
            $router->post('tambah/dari-barang-masuk', 'BarangMasukController@tambahBarangUntukBarangMasuk');
            $router->post('', 'BarangMasukController@tambahBarangMasuk');

            

        });

        $router->group(['prefix' => 'kategori'], function () use ($router){
            $router->get('', 'KategoriController@ambilKategori');
            $router->post('', 'KategoriController@tambahKategori');
            $router->put('{id}', 'KategoriController@ubahKategori');
            $router->delete('{id}', 'KategoriController@hapusKategori');

        });

        $router->group(['prefix' => 'satuan'], function () use ($router){
            $router->get('', 'SatuanController@ambilSatuan');
            $router->post('', 'SatuanController@tambahSatuan');
            $router->put('{id}', 'SatuanController@ubahSatuan');
            $router->delete('{id}', 'SatuanController@hapusSatuan');

        });

        $router->group(['prefix' => 'merek'], function () use ($router){
            $router->get('', 'MerekController@ambilMerek');
            $router->post('', 'MerekController@tambahMerek');
            $router->put('{id}', 'MerekController@ubahMerek');
            $router->delete('{id}', 'MerekController@hapusMerek');

        });

        $router->group(['prefix' => 'supplier'], function () use ($router){
            $router->get('', 'SupplierController@ambilSupplier');
            $router->post('', 'SupplierController@tambahSupplier');
            $router->put('{id}', 'SupplierController@ubahSupplier');
            $router->delete('{id}', 'SupplierController@hapusSupplier');

        });



        $router->group(['prefix' => 'karyawan'], function () use ($router){
            $router->get('', 'KaryawanController@ambilKaryawan');
            $router->post('', 'KaryawanController@tambahKaryawan');
            $router->put('{id}', 'KaryawanController@ubahKaryawan');
            $router->delete('{id}', 'KaryawanController@hapusKaryawan');
        });

        $router->group(['prefix' => 'toko'], function () use ($router){
            $router->get('', 'TokoController@ambilToko');
            $router->put('{id}', 'TokoController@ubahToko');
        });

        $router->group(['prefix' => 'kode'], function () use ($router){
            $router->group(['prefix' => 'barang'], function () use ($router){
                $router->get('', 'KodeBarangController@ambilKodeBarang');
                $router->put('{id}', 'KodeBarangController@ubahKodeBarang');
            });

            $router->group(['prefix' => 'transaksi'], function () use ($router){
                $router->get('', 'KodeTransaksiController@ambilKodeTransaksi');
                $router->put('{id}', 'KodeTransaksiController@ubahKodeTransaksi');
            });
            
        });




});
