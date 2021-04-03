<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KodeTransaksi;
use Illuminate\Support\Facades\Validator;

class KodeTransaksiController extends Controller
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

    public function ambilKodeTransaksi(){
        
        $data =  KodeTransaksi::select('id_kode_transaksi','huruf_kode_transaksi','jumlah_kode_transaksi')
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

    public function ubahKodeTransaksi(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'huruf_kode_transaksi' =>  'required',
            'jumlah_kode_transaksi' => 'required|numeric',
        ],[
            'huruf_kode_transaksi.required' => 'Harus diisi!',
            'jumlah_kode_transaksi.required' => 'Harus diisi!',
            'jumlah_kode_transaksi.numeric' => 'Harus angka!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Kode barang gagal diubah!',
                'data' => [
                    'huruf_kode_transaksi' => $validator->errors()->first('huruf_kode_transaksi'),
                    'jumlah_kode_transaksi' => $validator->errors()->first('jumlah_kode_transaksi')
                ]
                
            ], 422);
        }

        $model = KodeTransaksi::find($id);
        $model->huruf_kode_transaksi= $request->input('huruf_kode_transaksi');
        $model->jumlah_kode_transaksi = $request->input('jumlah_kode_transaksi');
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