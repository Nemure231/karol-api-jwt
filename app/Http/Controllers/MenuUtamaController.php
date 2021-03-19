<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  App\Models\MenuUtama;
use Illuminate\Support\Facades\Validator;

class MenuUtamaController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */

    public function ambilMenuUtamaUntukSidebar($id){

        $data = MenuUtama::join('menu', 'menu_utama.menu_id', '=', 'menu.id_menu')
        ->where('menu_utama.menu_id', $id)
        ->select('nama_menu_utama', 'id_menu_utama', 'ikon_menu_utama')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Menu utama barhasil ditemukan!',
            'data' => $data
        ], 200);
    }





  
}