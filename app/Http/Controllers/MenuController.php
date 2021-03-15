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

    public function ambilMenu($id){

        $data =  User::select('name', 'telepon', 'email', 'gambar', 'alamat')
            ->where('id', $id)
            ->first();

        return response()->json(['users' =>  $data], 200);
    }

    public function tambahMenu(Request $request){

        $model = User::find($id);
        $model->name = $request->input('name');
        $model->telepon = $request->input('telepon');
        $model->alamat = $request->input('alamat');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diubah!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User gagal diubahh!',
                'data' => '',
            ], 400);
        }

    }

    public function ubahMenu(Request $request, $id){

        $model = User::find($id);
        $model->name = $request->input('name');
        $model->telepon = $request->input('telepon');
        $model->alamat = $request->input('alamat');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diubah!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User gagal diubahh!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusMenu(Request $request, $id){

        $model = User::find($id);
        $model->name = $request->input('name');
        $model->telepon = $request->input('telepon');
        $model->alamat = $request->input('alamat');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diubah!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User gagal diubahh!',
                'data' => '',
            ], 400);
        }

    }

  
}