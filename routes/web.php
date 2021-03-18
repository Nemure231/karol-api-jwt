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

    $router->post('auth/register', 'AuthController@register');
    $router->post('auth/login', 'AuthController@login');
    $router->post('auth/logout', 'AuthController@logout');
    $router->get('auth/ambil_token', 'AuthController@ambil_token');
    $router->get('auth/me', 'AuthController@me');

    $router->get('akun/profil/{id}', 'UserController@ambilSatuUser');
    $router->get('akun/profil/untuk-profil/{id}', 'UserController@ambilSatuUserUntukProfil');
    $router->get('akun/profil/dengan-role/{id}', 'UserController@ambilSatuUserJoinRole');
    $router->put('akun/profil/ubah/{id}', 'UserController@ubahUser');

    $router->get('akun/sandi/{id}', 'UserController@ambilSatuSandi');
    $router->put('akun/sandi/ubah/{id}', 'UserController@ubahSandi');


    $router->get('pengaturan/menu/untuk-sidebar/{id}', 'MenuController@ambilMenuUntukSidebar');
    $router->get('pengaturan/menu', 'MenuController@ambilMenu');
    $router->get('pengaturan/menu/{id}', 'MenuController@ambilMenu');
    $router->post('pengaturan/menu/tambah', 'MenuController@tambahMenu');
    $router->put('pengaturan/menu/ubah/{id}', 'MenuController@ubahMenu');
    $router->delete('pengaturan/menu/hapus/{id}', 'MenuController@hapusMenu');
    // $router->post('pengaturan/menu/tambah/dari-submenu', 'MenuController@tambahMenuDariSubmenu');



    $router->get('pengaturan/submenu/untuk-sidebar/{menu_id}/{menu_utama_id}', 'SubmenuController@ambilSubmenuUntukSidebar');
    $router->get('pengaturan/submenu', 'SubmenuController@ambilSubmenu');
    $router->post('pengaturan/submenu/tambah', 'SubmenuController@tambahSubmenu');
    $router->put('pengaturan/submenu/ubah/{id}', 'SubmenuController@ubahSubmenu');
    $router->delete('pengaturan/submenu/hapus/{id}', 'SubmenuController@hapusSubmenu');

    // $router->post('pengaturan/menu_utama/tambah/dari-submenu', 'MenuUtamaController@tambahMenuUtamaDariSubmenu');
    
});
