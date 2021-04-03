<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KodeBarang;
use Illuminate\Support\Facades\Validator;

class KodeBarangController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */

    public function ambilKodeBarang(){
        
        $data =  KodeBarang::select('id_kode_barang','huruf_kode_barang','jumlah_kode_barang')
                    ->first();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Kode barang barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Kode barang gagal ditemukan!',
                    'data' => ''
            ], 404);
        }
    }

    public function ubahKodeBarang(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'huruf_kode_barang' =>  'required',
            'jumlah_kode_barang' => 'required|numeric',
        ],[
            'huruf_kode_barang.required' => 'Harus diisi!',
            'jumlah_kode_barang.required' => 'Harus diisi!',
            'jumlah_kode_barang.numeric' => 'Harus angka!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode barang gagal diubah!',
                'data' => [
                    'huruf_kode_barang' => $validator->errors()->first('huruf_kode_barang'),
                    'jumlah_kode_barang' => $validator->errors()->first('jumlah_kode_barang')
                ]
                
            ], 422);
        }

        $model = KodeBarang::find($id);
        $model->huruf_kode_barang= $request->input('huruf_kode_barang');
        $model->jumlah_kode_barang = $request->input('jumlah_kode_barang');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Kode barang berhasil diubah!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Kode barang gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

}