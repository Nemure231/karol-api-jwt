<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  App\Models\Menu;
use Illuminate\Support\Facades\Validator;

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
        $data = Menu::join('akses_role', 'menu.id_menu', '=', 'akses_role.menu_id')
        ->select('id_menu', 'nama_menu')
        ->where('role_id', $id)
        ->orderBy('akses_role.menu_id', 'asc')
        ->orderBy('akses_role.role_id', 'asc')
        ->get();

        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Menu barhasil ditemukan!',
                'data' => $data
            ], 200);
        }
        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function ambilMenuUntukDaftarRoleAkses(){
        $data = Menu::where([
                ['id_menu', '!=', '1'],
                ['nama_menu', '!=', 'Role'],
            ])->select('id_menu', 'nama_menu')->get();
        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Menu barhasil ditemukan!',
                'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function ambilMenu(){

        $data =  Menu::select('id_menu', 'nama_menu')->get();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Menu barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }   



    public function tambahMenu(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|unique:menu,nama_menu'
        ],[

            'nama_menu.required' => 'Harus diisi!',
            'nama_menu.unique' => 'Menu itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal diubah!',
                'data' => [
                    'nama_menu' => $validator->errors()->first('nama_menu')
                ]
            ], 422);
        }       

        $model = new Menu;
        $model->nama_menu = $request->nama_menu;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
    }

    public function ubahMenu(Request $request, $id){


        $validator = Validator::make($request->all(), [
            'nama_menu' =>  'required|unique:menu,nama_menu,'.$id.',id_menu'
        ],[
            'nama_menu.required' => 'Harus diisi!',
            'nama_menu.unique' => 'Menu itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'success' => false,
                    'message' => 'Menu gagal diubah!',
                    'nama_menu' => $validator->errors()->first('nama_menu')
                ]
            ], 422);
        }

        $model = Menu::find($id);
        $model->nama_menu = $request->nama_menu;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil diubah!',
                'data' => ''
            ], 201);
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
        }
        
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}