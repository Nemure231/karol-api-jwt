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
        // $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */

    public function ambilToko(){

        $data =  Toko::select('id_toko', 'nama_toko', 'email_toko','telepon_toko', 'alamat_toko', 'logo_toko', 'logo_koperasi')->first();

        if($data){
            $result1 = data_fill($data, 'url_logo_toko', asset('gambar/toko').'/'.$data['logo_toko']);
            $result2 = data_fill($result1, 'url_logo_koperasi', asset('gambar/toko').'/'.$data['logo_koperasi']);
            return response()->json([
                    'success' => true,
                    'message' => 'Toko barhasil ditemukan!',
                    'data' => $result2
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
            'logo_toko' => 'image|max:1024|mimes:jpg,jepg,png|mimetypes:image/jpg,image/jpeg,image/png',
            'logo_koperasi' => 'image|max:1024|mimes:jpg,jepg,png|mimetypes:image/jpg,image/jpeg,image/png'
        ],[
            'nama_toko.required' => 'Harus diisi!',
            'telepon_toko.required' => 'Harus diisi!',
            'telepon_toko.numeric' => 'Harus angka!',
            'email_toko.required' => 'Harus diisi!',
            'email_toko.email' => 'Harus bertipe e-mail!',
            'alamat_toko.required' => 'Harus diisi!',
            'logo_toko.image' => 'Harus gambar!',
            'logo_toko.max' => 'Minimal upload 1MB!',
            'logo_toko.mimes' => 'Tipe file tersebut bukan gambar!',
            'logo_toko.mimetype' => 'Tipe file tersebut bukan gambar!',
            'logo_koperasi.image' => 'Harus gambar!',
            'logo_koperasi.max' => 'Minimal upload 1MB!',
            'logo_koperasi.mimes' => 'Tipe file tersebut bukan gambar!',
            'logo_koperasi.mimetype' => 'Tipe file tersebut bukan gambar!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Toko gagal diubah!',
                'data' => [
                    'nama_toko' => $validator->errors()->first('nama_toko'),
                    'telepon_toko' => $validator->errors()->first('telepon_toko'),
                    'email_toko' => $validator->errors()->first('email_toko'),
                    'alamat_toko' => $validator->errors()->first('alamat_toko'),
                    'logo_toko' => $validator->errors()->first('logo_toko'),
                    'logo_koperasi' => $validator->errors()->first('logo_koperasi')
                ]
            ], 422);
        }

        $logo_toko = $request->file('logo_toko');
        $nama_file_toko = $logo_toko->getClientOriginalName();

        if ($logo_toko->isValid()) {
            if ($nama_file_toko != 'default.png'){
                $logo_toko_lama = Toko::select('logo_toko')->where('id_toko', $id)->first();
                unlink(storage_path('/app/toko/'.$logo_toko_lama['logo_toko']));
                // Storage::disk('toko')->delete('/'.$logo_toko_lama['logo_toko']);
                $nama_logo_toko = time().'_'.preg_replace('/\s+/', '_', $nama_file_toko);
                $logo_toko->storeAs('toko', $nama_logo_toko);
            }else{
                $logo_toko_lama2 = Toko::select('logo_toko')->where('id_toko', $id)->first();
                $nama_logo_toko = $logo_toko_lama2['logo_toko'];
            }
        }

        $logo_koperasi = $request->file('logo_koperasi');
        $nama_file_koperasi = $logo_koperasi->getClientOriginalName();

        if ($logo_koperasi->isValid()) {
            if ($nama_file_koperasi != 'default.png'){
                $logo_koperasi_lama = Toko::select('logo_koperasi')->where('id_toko', $id)->first();
                unlink(storage_path('/app/toko/'.$logo_koperasi_lama['logo_koperasi']));
                // Storage::disk('toko')->delete('/'.$logo_koperasi_lama['logo_koperasi']);
                $nama_logo_koperasi = time().'_'.preg_replace('/\s+/', '_', $nama_file_koperasi);
                $logo_koperasi->storeAs('toko', $nama_logo_koperasi);
                
            }else{
                $logo_koperasi_lama2 = Toko::select('logo_koperasi')->where('id_toko', $id)->first();
                $nama_logo_koperasi = $logo_koperasi_lama2['logo_koperasi'];
            }
        }

        $model = Toko::find($id);
        $model->nama_toko = $request->input('nama_toko');
        $model->telepon_toko = $request->input('telepon_toko');
        $model->email_toko = $request->input('email_toko');
        $model->alamat_toko = $request->input('alamat_toko');
        $model->logo_toko = $nama_logo_toko; //?? '1617275075_ppppp.jpg';
        $model->logo_koperasi = $nama_logo_koperasi;// ?? '1617275075_ppppp.jpg';
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

  
}