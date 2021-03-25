<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AksesRole;
use App\Models\Menu;
use lluminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AKsesRoleController extends Controller
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

    public function cekCentangAksesRole($role_id, $menu_id){
        $data = AksesRole::where(['role_id' => $role_id, 'menu_id' => $menu_id])
                ->count();
        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Menu tersebut ada!',
                'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Menu tersebut tidak ada!',
                'data' => ''
            ], 401);
        }
    }

    public function cekAksesUser($role_id, $uri_menu){

        $menu = Menu::select('id_menu')
                ->where('nama_menu', $uri_menu)
                ->first();
        $menu_id = $menu['id_menu'];

        $data = AksesRole::where(['role_id' => $role_id, 'menu_id' => $menu_id])
                ->count();

        if($data){
            return response()->json([
                'success' => true,
                'message' => 'User tersebut berhak mengakses menu!',
                'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'User tersebut tidak berhak mengakses menu!',
                'data' => ''
            ], 405);
        }
    }

    public function ubahAksesRole(Request $request, $id_role, $id_menu){
        $data = AksesRole::where(['role_id' => $id_role, 'menu_id' => $id_menu])
                ->count();

        $menu_id = $request->menu_id;
        $role_id = $request->role_id;
            
        $model = new AksesRole;
        if($data < 1){
            $model->role_id = $role_id;
            $model->menu_id = $menu_id;
            $model->save();
            return response()->json([
                'success' => true,
                'message' => 'Akses role berhasil diubah!',
                'data' => ''
            ], 201);
        }else{
            $model::where(['role_id' => $role_id, 'menu_id' => $menu_id])->delete();
            return response()->json([
                'success' => true,
                'message' => 'Akses role berhasil diubah!',
                'data' => ''
            ], 201);
            
        }
    }

   

  
}