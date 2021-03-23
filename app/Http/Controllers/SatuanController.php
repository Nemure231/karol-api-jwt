<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
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

    public function ambilSatuan(){

        $data =  Satuan::select('id_satuan', 'nama_satuan')->get();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Satuan barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Satuan gagal ditemukan!',
                    'data' => ''
            ], 200);
        }


    }


    public function tambahSatuan(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_satuan' => 'required|unique:satuan,nama_satuan'
        ],[

            'nama_satuan.required' => 'Satuan harus diisi!',
            'nama_satuan.unique' => 'Satuan itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'nama_satuan' => $validator->errors()->first('nama_satuan')
                ]
            ], 422);
        }       

        $model = new Satuan;
        $model->nama_satuan = $request->input('nama_satuan');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
    }

    public function ubahSatuan(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nama_satuan' =>  'required|unique:satuan,nama_satuan,'.$id.',id_satuan'
        ],[
            'nama_satuan.required' => 'Satuan harus diisi!',
            'nama_satuan.unique' => 'Satuan itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'nama_satuan' => $validator->errors()->first('nama_satuan')
                ]
            ], 422);
        }

        $model = Satuan::find($id);
        $model->nama_satuan = $request->input('nama_satuan');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil diubah!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Satuan gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusSatuan($id){

        $model = Satuan::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Satuan berhasil dihapus!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Satuan gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}