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


    public function tambahMenuUtamaDariSubmenu(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_menu_utama' => 'required',
            'menu_id' => 'required',
            'ikon_menu_utama' => 'required',

        ],[
            'nama_menu_utama.required' => 'Nama menu utama harus dipilih!',
            'menu_id.required' => 'Nama menu harus dipilih!',
            'ikon_menu_utama.required' => 'Ikon menu utama harus diisi!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()], 422);
        }

        $nama_menu_utama = $request->nama_menu_utama;
        $menu_id = $request->menu_id;
        $ikon_menu_utama = $request->ikon_menu_utama;

        $data = MenuUtama::insertGetId(['menu_id' => $menu_id, 'nama_menu_utama' => $nama_menu_utama, 'ikon_menu_utama' => $ikon_menu_utama]);
        return response()->json([
            'success' => true,
            'message' => 'Menu utama barhasil ditambahkan!',
            'data' => $data
        ], 200);

    }



  
}