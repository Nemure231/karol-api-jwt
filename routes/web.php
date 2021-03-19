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

        $router->get('profil/{id}', 'UserController@ambilSatuUser');
        $router->get('profil/untuk-profil/{id}', 'UserController@ambilSatuUserUntukProfil');
        $router->get('profil/dengan-role/{id}', 'UserController@ambilSatuUserJoinRole');
        $router->put('profil/ubah/{id}', 'UserController@ubahUser');

        $router->get('sandi/{id}', 'UserController@ambilSatuSandi');
        $router->put('sandi/ubah/{id}', 'UserController@ubahSandi');
    });

    $router->group(['prefix' => 'pengaturan'], function () use ($router){

        $router->get('menu/untuk-sidebar/{id}', 'MenuController@ambilMenuUntukSidebar');
        $router->get('menu', 'MenuController@ambilMenu');
        $router->get('menu/{id}', 'MenuController@ambilMenu');
        $router->post('menu/tambah', 'MenuController@tambahMenu');
        $router->put('menu/ubah/{id}', 'MenuController@ubahMenu');
        $router->delete('menu/hapus/{id}', 'MenuController@hapusMenu');


        $router->get('submenu/untuk-sidebar/{menu_id}/{menu_utama_id}', 'SubmenuController@ambilSubmenuUntukSidebar');
        $router->get('submenu', 'SubmenuController@ambilSubmenu');
        $router->post('submenu/tambah', 'SubmenuController@tambahSubmenu');
        $router->put('submenu/ubah/{id}', 'SubmenuController@ubahSubmenu');
        $router->delete('submenu/hapus/{id}', 'SubmenuController@hapusSubmenu');

        $router->get('role', 'RoleController@ambilRole');
        $router->post('role/tambah', 'RoleController@tambahRole');
        $router->put('role/ubah/{id}', 'RoleController@ubahRole');
        $router->delete('role/hapus/{id}', 'RoleController@hapusRole');

    });



});
