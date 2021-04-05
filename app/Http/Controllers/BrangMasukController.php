<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\Validator;

class BarangMasukController extends Controller
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


    public function ambilMerek(){

        $data =  Merek::select('id_merek', 'nama_merek')->get();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Merek barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Merek gagal ditemukan!',
                    'data' => ''
            ], 404);
        }


    }


    public function tambahMerek(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_merek' => 'required|unique:merek,nama_merek'
        ],[

            'nama_merek.required' => 'Harus diisi!',
            'nama_merek.unique' => 'Merek itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Merek gagal ditambahkan!',
                'data' => [
                    'nama_merek' => $validator->errors()->first('nama_merek')
                ]
            ], 422);
        }       

        $model = new Merek;
        $model->nama_merek = $request->input('nama_merek');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Merek berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
    }

    public function ubahMerek(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nama_merek' =>  'required|unique:merek,nama_merek,'.$id.',id_merek'
        ],[
            'nama_merek.required' => 'Harus diisi!',
            'nama_merek.unique' => 'Merek itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Merek gagal ditambahkan!',
                'data' => [
                    'nama_merek' => $validator->errors()->first('nama_merek')
                ]
            ], 422);
        }

        $model = Merek::find($id);
        $model->nama_merek = $request->input('nama_merek');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Merek berhasil diubah!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Merek gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusMerek($id){

        $model = Merek::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Merek berhasil dihapus!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Merek gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}