<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Submenu;
use App\Models\Menu;
use App\Models\MenuUtama;
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
        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Submenu barhasil ditemukan!',
                'data' => $data
            ], 200);
        }
        if(!$data){
            return response()->json([
                'success' => true,
                'message' => 'Submenu gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function ambilSubMenu(){

        $data =  Submenu::join('menu', 'submenu.menu_id', '=', 'menu.id_menu')
                    ->join('menu_utama', 'submenu.menu_utama_id', '=', 'menu_utama.id_menu_utama')
                    ->select('id_menu', 'nama_menu', 'submenu.menu_id as menu_id', 'id_menu_utama',
                    'nama_menu_utama', 'nama_submenu', 'url_submenu', 'ikon_submenu', 'status_submenu', 
                    'id_submenu', 'menu_utama_id')
                    ->get();
        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Submenu barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }
        if(!$data){
            return response()->json([
                'success' => true,
                'message' => 'Submenu gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function tambahSubmenu(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_submenu' => 'required|unique:submenu,nama_submenu',
            'url_submenu' => 'required|unique:submenu,url_submenu',
            'ikon_submenu' => 'required',
            'menu_id' => 'required',
            'menu_utama_id' => 'required'

        ],[
            'nama_submenu.required' => 'Harus diisi!',
            'nama_submenu.unique' => 'Submenu itu sudah ada!',
            'url_submenu.required' => 'Harus diisi!',
            'url_submenu.unique' => 'Url itu sudah ada!',
            'ikon_submenu.required' => 'Harus diisi!',
            'menu_id.required' => 'Harus dipilih!',
            'menu_utama_id.required' => 'Harus dipilih!'
        ]);

        if ($validator->fails()) {
            // return response()->json(['data' => $validator->errors()->all()], 422);

            return response()->json([
                'success' => false,
                'message' => 'Submenu gagal diubah!',
                'data' => [
                    'menu_id' => $validator->errors()->first('menu_id'),
                    'menu_utama_id' =>$validator->errors()->first('menu_utama_id'),
                    'nama_submenu' =>$validator->errors()->first('nama_submenu'),
                    'url_submenu'=>$validator->errors()->first('url_submenu'),
                    'ikon_submenu' => $validator->errors()->first('ikon_submenu'),
            ]], 422);

        }

        $menu_id = $request->input('menu_id');
        if (is_numeric($menu_id)){
            $id_menu = $menu_id;
        }else{
            $id_menu = Menu::insertGetId([
                'nama_menu' => $menu_id,
                
                
            ]);
        }
        
        $ikon = $request->input('ikon_submenu');
        $menu_utama_id = $request->input('menu_utama_id');
        if (is_numeric($menu_utama_id)){
            $id_menu_utama = $menu_utama_id;
        }else{
            $id_menu_utama = MenuUtama::insertGetId([
                'menu_id' => $id_menu,
                'nama_menu_utama' => $menu_utama_id, 
                'ikon_menu_utama' => $ikon,
                
                
            ]);
        }

        $model = new Submenu;
        $model->menu_id = $id_menu;
        $model->menu_utama_id = $id_menu_utama;
        $model->nama_submenu = $request->input('nama_submenu');
        $model->url_submenu = $request->input('url_submenu');
        $model->ikon_submenu = $ikon;
        $model->status_submenu = $request->input('status_submenu');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Submenu berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
    }
    

    public function ubahSubmenu(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nama_submenu' => 'required|unique:submenu,nama_submenu,'.$id.',id_submenu',
            'url_submenu' => 'required|unique:submenu,url_submenu,'.$id.',id_submenu',
            'ikon_submenu' => 'required',
            'menu_id' => 'required',
            'menu_utama_id' => 'required'

        ],[
            'nama_submenu.required' => 'Harus diisi!',
            'nama_submenu.unique' => 'Submenu itu sudah ada!',
            'url_submenu.required' => 'Harus diisi!',
            'url_submenu.unique' => 'Url itu sudah ada!',
            'ikon_submenu.required' => 'Harus diisi!',
            'menu_id.required' => 'Harus dipilih!',
            'menu_utama_id.required' => 'Harus dipilih!'
        ]);

        if ($validator->fails()) {
            // return response()->json(['data' => $validator->errors()->all()], 422);

            return response()->json([
                'success' => false,
                'message' => 'Submenu gagal diubah!',
                'data' => [
                    'menu_id' => $validator->errors()->first('menu_id'),
                    'menu_utama_id' =>$validator->errors()->first('menu_utama_id'),
                    'nama_submenu' =>$validator->errors()->first('nama_submenu'),
                    'url_submenu'=>$validator->errors()->first('url_submenu'),
                    'ikon_submenu' => $validator->errors()->first('ikon_submenu'),
            ]], 422);

        }

        $menu_id = $request->input('menu_id');
        if (is_numeric($menu_id)){
            $id_menu = $menu_id;
        }else{
            $id_menu = Menu::insertGetId([
                'nama_menu' => $menu_id,
                
                
            ]);
        }
        
        $ikon = $request->input('ikon_submenu');
        $menu_utama_id = $request->input('menu_utama_id');
        if (is_numeric($menu_utama_id)){
            $id_menu_utama = $menu_utama_id;
        }else{
            $id_menu_utama = MenuUtama::insertGetId([
                'menu_id' => $id_menu,
                'nama_menu_utama' => $menu_utama_id, 
                'ikon_menu_utama' => $ikon,
                
                
            ]);
        }

        $model = Submenu::find($id);
        $model->menu_id = $id_menu;
        $model->menu_utama_id = $id_menu_utama;
        $model->nama_submenu = $request->input('nama_submenu');
        $model->url_submenu = $request->input('url_submenu');
        $model->ikon_submenu = $ikon;
        $model->status_submenu = $request->input('status_submenu');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Submenu berhasil diubah!',
                'data' => ''
            ], 201);
        }

        if(!$model){
            return response()->json([
                'success' => true,
                'message' => 'Submenu gagal diubah!',
                'data' => ''
            ], 400);
        }
    }


    public function hapusSubmenu($id){

        $model = Submenu::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Submenu berhasil dihapus!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Submenu gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}