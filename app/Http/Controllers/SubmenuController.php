<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Submenu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SubmenuController extends Controller
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
    public function ambilSubmenuUntukSidebar($menu_id, $menu_utama_id){
        $data = Submenu::join('menu', 'submenu.menu_id', '=', 'menu.id_menu')
                        ->select('nama_submenu', 'id_submenu', 'url_submenu', 'ikon_submenu')
                        ->where('submenu.menu_id', $menu_id)
                        ->where('submenu.menu_utama_id', $menu_utama_id)
                        ->where('submenu.status_submenu', 1)
                        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Submenu barhasil ditemukan!',
            'data' => $data
        ], 200);
    }

    public function ambilSubMenu(){

        $data =  Submenu::join('menu', 'submenu.menu_id', '=', 'menu.id_menu')
                    ->join('menu_utama', 'submenu.menu_utama_id', '=', 'menu_utama.id_menu_utama')
                    ->select('id_menu', 'nama_menu', 'submenu.menu_id as menu_id', 'id_menu_utama',
                    'nama_menu_utama', 'nama_submenu', 'url_submenu', 'ikon_submenu', 'status_submenu', 
                    'id_submenu', 'menu_utama_id')
                    ->get();

        return response()->json([
                'success' => true,
                'message' => 'Submenu barhasil ditemukan!',
                'data' => $data
        ], 200);
    }

    public function tambahSubmenu(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_submenu' => 'required|string|unique:submenu,nama_submenu',
            'url_submenu' => 'required|unique:submenu,url_submenu',
            'ikon_submenu' => 'required',
            'menu_id' => 'required',
            'menu_utama_id' => 'required'

        ],[
            'nama_submenu.required' => 'Nama submenu harus diisi!',
            'nama_submenu.string' => 'Nama submenu harus bertipe string!',
            'nama_submenu.unique' => 'Nama submenu itu sudah ada!',
            'url_submenu.required' => 'Url submenu harus diisi!',
            'url_submenu.unique' => 'Url submenu itu sudah ada!',
            'ikon_submenu.required' => 'Ikon submenu harus diisi!',
            'menu_id.required' => 'Nama menu harus dipilih!',
            'menu_utama_id.required' => 'Nama menu utama harus dipilih!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()], 422);
        }

        // $status_menu = $request->status_submenu;

        // if(!$status_menu){
        //     $status_menu = 2;
        // }

        $model = new Submenu;
        $model->menu_id = $request->menu_id;
        $model->menu_utama_id = $request->menu_utama_id;
        $model->nama_submenu = $request->nama_submenu;
        $model->url_submenu = $request->url_submenu;
        $model->ikon_submenu = $request->ikon_submenu;
        $model->status_submenu = $request->status_submenu;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Submenu berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Submenu gagal ditambahkan!',
                'data' => '',
            ], 400);
        }
    }

    public function ubahMenu(Request $request, $id){

        $old =  $request->old('nama_menu');
        $baru = $request->input('nama_menu');
    
        
        if($old != null){
            $rules =  'required|string|unique:menu,nama_menu';
        }else{
            $rules = 'required|string';
        }

        $validator = Validator::make($request->all(), [
            'nama_menu' =>  $rules
        ],[

            'nama_menu.required' => 'Menu harus diisi!',
            'nama_menu.string' => 'Menu harus bertipe string!',
            'nama_menu.unique' => 'Menu itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()], 422);
        }  

        $model = Menu::find($id);
        $model->nama_menu = $request->nama_menu;
        $model->save();

        // Menu::where('id_menu', $id)->updateOrInsert(
        //     ['nama_menu' => $request->nama_menu],
        //     ['nama_menu' => $request->nama_menu]
        // );

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