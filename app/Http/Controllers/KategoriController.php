<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use  App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
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

    public function ambilKategori(){

        $data =  Kategori::select('id_kategori', 'nama_kategori')->get();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Kategori barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Kategori gagal ditemukan!',
                    'data' => ''
            ], 200);
        }


    }


    public function tambahKategori(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategori,nama_kategori'
        ],[

            'nama_kategori.required' => 'Kategori harus diisi!',
            'nama_kategori.unique' => 'Kategori itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }       

        $model = new Kategori;
        $model->nama_kategori = $request->nama_kategori;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }

        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal ditambahkan!',
                'data' => '',
            ], 400);
        }
    }

    public function ubahKategori(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nama_kategori' =>  'required|unique:kategori,nama_kategori,'.$id.',id_kategori'
        ],[
            'nama_kategori.required' => 'Kategori harus diisi!',
            'nama_kategori.unique' => 'Kategori itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }

        $model = Kategori::find($id);
        $model->nama_kategori = $request->nama_kategori;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diubah!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusKategori($id){

        $model = Kategori::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Kategori gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}