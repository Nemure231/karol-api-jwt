<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Merek;
use Illuminate\Support\Facades\Validator;

class MerekController extends Controller
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
            ], 200);
        }


    }


    public function tambahMerek(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_merek' => 'required|unique:merek,nama_merek'
        ],[

            'nama_merek.required' => 'Merek harus diisi!',
            'nama_merek.unique' => 'Merek itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }       

        $model = new Merek;
        $model->nama_merek = $request->nama_merek;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Merek berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }

        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Merek gagal ditambahkan!',
                'data' => '',
            ], 400);
        }
    }

    public function ubahMerek(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nama_merek' =>  'required|unique:merek,nama_merek,'.$id.',id_merek'
        ],[
            'nama_merek.required' => 'Merek harus diisi!',
            'nama_merek.unique' => 'Merek itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }

        $model = Merek::find($id);
        $model->nama_merek = $request->nama_merek;
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