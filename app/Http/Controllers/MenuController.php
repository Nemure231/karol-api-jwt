<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  App\Models\Menu;
use Illuminate\Support\Facades\Hash;

class MenuController extends Controller
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

    public function ambilMenuUntukSidebar($id){
        $data = Menu::join('akses_menu', 'menu.id_menu', '=', 'akses_menu.menu_id')
        ->select('id_menu', 'nama_menu')
        ->where('role_id', $id)
        ->orderBy('akses_menu.menu_id', 'asc')
        ->orderBy('akses_menu.role_id', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Menu barhasil ditemukan!',
            'data' => $data
        ], 200);
    }

    public function ambilMenu($id = null){

        if($id == null){
            $data =  Menu::select('id_menu', 'nama_menu')->get();
        }else{
            $data = Menu::select('id_menu', 'nama_menu')->where('id_menu', $id)->get();
        }

        return response()->json([
                'success' => true,
                'message' => 'Menu barhasil ditemukan!',
                'data' => $data
        ], 200);
    }

    public function tambahMenu(Request $request){

        $model = new Menu;
        $model->nama_menu = $request->nama_menu;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Menu berhasil ditambahkan!',
                'data' => '',
            ], 400);
        }

    }

    public function ubahMenu(Request $request, $id){

        $model = Menu::find($id);
        $model->nama_menu = $request->nama_menu;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diubah!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusMenu($id){

        $model = Menu::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil dihapus!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}