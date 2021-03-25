<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Toko;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
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

    public function ambilToko(){

        $data =  Toko::select('id_toko', 'nama_toko', 'email_toko','telepon_toko', 'alamat_toko', 'logo_toko')->first();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Toko barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Toko gagal ditemukan!',
                'data' => ''
            ], 404);
        }
    }   

    public function ubahToko(Request $request, $id){


        $validator = Validator::make($request->all(), [
            'nama_toko' =>  'required',
            'telepon_toko' => 'required|numeric',
            'email_toko' => 'required|email',
            'alamat_toko' => 'required',
            'logo_toko' => 'required'
        ],[
            'nama_toko.required' => 'Harus diisi!',
            'telepon_toko.required' => 'Harus diisi!',
            'telepon_toko.numeric' => 'Harus angka!',
            'email_toko.reuired' => 'Harus diisi!',
            'email_toko.email' => 'Harus bertipe e-mail!',
            'alamat_toko.required' => 'Harus diisi!',
            'logo_toko' => 'Harus diisi!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal diubah!',
                'data' => [
                    'nama_toko' => $validator->errors()->first('nama_toko'),
                    'telepon_toko' => $validator->errors()->first('telepon_toko'),
                    'email_toko' => $validator->errors()->first('email_toko'),
                    'alamat_toko' => $validator->errors()->first('alamat_toko'),
                    'logo_toko' => $validator->errors()->first('logo_toko')
                ]
            ], 422);
        }

        $model = Toko::find($id);
        $model->nama_toko = $request->input('nama_toko');
        $model->telepon_toko = $request->input('telepon_toko');
        $model->email_toko = $request->input('email_toko');
        $model->alamat_toko = $request->input('alamat_toko');
        $model->logo_toko = $request->input('logo_toko');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Toko berhasil diubah!',
                'data' => ''
            ], 201);
        }

        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Toko gagal diubah!',
                'data' => ''
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
        }
        
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Menu gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}