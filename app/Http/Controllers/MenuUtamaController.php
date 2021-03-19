<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MenuUtama;
use App\Models\Menu;
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

    public function ambilMenuUtama(){

        $data =  MenuUtama::join('menu', 'menu_utama.menu_id', '=', 'menu.id_menu')
                    ->select('id_menu_utama', 'nama_menu','nama_menu_utama', 'menu_id','ikon_menu_utama')
                    ->get();

        return response()->json([
                'success' => true,
                'message' => 'Menu utama barhasil ditemukan!',
                'data' => $data
        ], 200);
    }


    public function tambahMenuUtama(Request $request){

        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'nama_menu_utama' => 'required|unique:menu_utama,nama_menu_utama',
            'ikon_menu_utama' => 'required'
        ],[
            'menu_id.required' => 'Nama menu harus dipilih!',
            'nama_menu_utama.required' => 'Menu utama harus diisi!',
            'nama_menu_utama.unique' => 'Menu utama itu sudah ada!',
            'ikon_menu_utama.required' => 'Ikon menu utama harus diisi!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }

        $menu_id = $request->menu_id;
        if (is_numeric($menu_id)){
            $id_menu = $menu_id;
        }else{
            $id_menu = Menu::insertGetId(['nama_menu' => $menu_id]);
        }

        $model = new MenuUtama;
        $model->menu_id = $id_menu;
        $model->nama_menu_utama = $request->nama_menu_utama;
        $model->ikon_menu_utama = $request->ikon_menu_utama;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Menu utama gagal ditambahkan!',
                'data' => '',
            ], 400);
        }
    }

    public function ubahMenuUtama(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'menu_id'         => 'required',
            'nama_menu_utama' => 'required|unique:menu_utama,nama_menu_utama,'.$id.',id_menu_utama',
            'ikon_menu_utama' => 'required'
        ],[
            'menu_id.required'                  => 'Nama menu harus dipilih',
            'nama_menu_utama.required' => 'Menu utama harus diisi!',
            'nama_menu_utama.unique' => 'Menu utama itu sudah ada!',
            'ikon_menu_utama.required' => 'Ikon menu utama harus diisi!'
        ]);


        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }

        $menu_id = $request->menu_id;
        if (is_numeric($menu_id)){
            $id_menu = $menu_id;
        }else{
            $id_menu = Menu::insertGetId(['nama_menu' => $menu_id]);
        }

        $model = MenuUtama::find($id);
        $model->menu_id = $id_menu;
        $model->nama_menu_utama = $request->nama_menu_utama;
        $model->ikon_menu_utama = $request->ikon_menu_utama;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama berhasil diubah!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Menu utama gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusMenuUtama($id){

        $model = MenuUtama::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama berhasil dihapus!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Menu utama gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }





  
}