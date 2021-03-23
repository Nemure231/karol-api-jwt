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

        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama barhasil ditemukan!',
                'data' => $data
            ], 200);
        }
        if(!$data){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function ambilMenuUtamaUntukSubmenu(){

        $data =  MenuUtama::select('id_menu_utama','nama_menu_utama','ikon_menu_utama')
                    ->get();

        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama barhasil ditemukan!',
                'data' => $data
            ], 200);
        }
        if(!$data){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function ambilMenuUtamaJoinMenu(){

        $data =  MenuUtama::join('menu', 'menu_utama.menu_id', '=', 'menu.id_menu')
                    ->select('id_menu_utama', 'nama_menu','nama_menu_utama', 'menu_id','ikon_menu_utama')
                    ->get();

        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama barhasil ditemukan!',
                'data' => $data
            ], 200);
        }
        if(!$data){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }


    public function tambahMenuUtama(Request $request){

        $validator = Validator::make($request->all(), [
            'menu_id' => 'required',
            'nama_menu_utama' => 'required|unique:menu_utama,nama_menu_utama',
            'ikon_menu_utama' => 'required'
        ],[
            'menu_id.required' => 'Harus dipilih!',
            'nama_menu_utama.required' => 'Harus diisi!',
            'nama_menu_utama.unique' => 'Menu utama itu sudah ada!',
            'ikon_menu_utama.required' => 'Harus diisi!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'menu_id' => $validator->errors()->first('menu_id'),
                    'nama_menu_utama' =>$validator->errors()->first('nama_menu_utama'),
                    'ikon_menu_utama' => $validator->errors()->first('ikon_menu_utama'),
            ]], 422);
        }

        $menu_id = $request->menu_id;
        if (is_numeric($menu_id)){
            $id_menu = $menu_id;
        }else{
            $id_menu = Menu::insertGetId(['nama_menu' => $menu_id]);
        }

        $model = new MenuUtama;
        $model->menu_id = $id_menu;
        $model->nama_menu_utama = $request->input('nama_menu_utama');
        $model->ikon_menu_utama = $request->input('ikon_menu_utama');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
    }

    public function ubahMenuUtama(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'menu_id'         => 'required',
            'nama_menu_utama' => 'required|unique:menu_utama,nama_menu_utama,'.$id.',id_menu_utama',
            'ikon_menu_utama' => 'required'
        ],[
            'menu_id.required'      => 'Harus dipilih',
            'nama_menu_utama.required' => 'harus diisi!',
            'nama_menu_utama.unique' => 'Menu utama itu sudah ada!',
            'ikon_menu_utama.required' => 'Harus diisi!'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'menu_id' => $validator->errors()->first('menu_id'),
                    'nama_menu_utama' =>$validator->errors()->first('nama_menu_utama'),
                    'ikon_menu_utama' => $validator->errors()->first('ikon_menu_utama'),
            ]], 422);
        }

        $menu_id = $request->input('menu_id');
        if (is_numeric($menu_id)){
            $id_menu = $menu_id;
        }else{
            $id_menu = Menu::insertGetId(['nama_menu' => $menu_id]);
        }

        $model = MenuUtama::find($id);
        $model->menu_id = $id_menu;
        $model->nama_menu_utama = $request->input('nama_menu_utama');
        $model->ikon_menu_utama = $request->input('ikon_menu_utama');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu utama berhasil diubah!',
                'data' => ''
            ], 201);
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
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Menu utama gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }





  
}