<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
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


    public function ambilRole(){

        $data =  Role::where('id_role', '!=', 4)
                    ->where('id_role', '!=', 5)
                    ->select('id_role', 'nama_role')
                    ->get();
        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Role barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Role gagal ditemukan!',
                    'data' => ''
            ], 404);
        }
    }

    public function ambilRoleUntukCekCentangAksesRole($id){
        $data = Role::where('id_role', $id)
                ->select('id_role', 'nama_role')
                ->first();
        if($data){
            return response()->json([
                'success' => true,
                'message' => 'Role barhasil ditemukan!',
                'data' => $data
            ], 200);
        }
        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Role gagal ditemukan!',
                    'data' => ''
            ], 404);
        }
    }

    public function tambahRole(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_role' => 'required|unique:role,nama_role'
        ],[

            'nama_role.required' => 'Harus diisi!',
            'nama_role.unique' => 'Role itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'nama_role' =>$validator->errors()->first('nama_role')
            ]], 422);
        }       

        $model = new Role;
        $model->nama_role = $request->nama_role;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
    }

    public function ubahRole(Request $request, $id){


        $validator = Validator::make($request->all(), [
            'nama_role' =>  'required|unique:role,nama_role,'.$id.',id_role'
        ],[
            'nama_role.required' => 'Harus diisi!',
            'nama_role.unique' => 'Role itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'nama_role' =>$validator->errors()->first('nama_role')
            ]], 422);
        }

        $model = Role::find($id);
        $model->nama_role = $request->nama_role;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diubah!',
                'data' => ''
            ], 201);
        }

    }

    public function hapusRole($id){

        $model = Role::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil dihapus!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Role gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}