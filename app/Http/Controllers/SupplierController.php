<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
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

    public function ambilSupplier(){

        $data =  Supplier::select('id_supplier', 'nama_supplier')->get();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Supplier barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Supplier gagal ditemukan!',
                    'data' => ''
            ], 404);
        }


    }


    public function tambahSupplier(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required|unique:supplier,nama_supplier'
        ],[

            'nama_supplier.required' => 'Supplier harus diisi!',
            'nama_supplier.unique' => 'Supplier itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier gagal ditambahkan!',
                'data' => [
                    'nama_supplier' => $validator->errors()->first('nama_supplier')
                ]
            ], 422);
        }       

        $model = new Supplier;
        $model->nama_supplier = $request->input('nama_supplier');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
    }

    public function ubahSupplier(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nama_supplier' =>  'required|unique:supplier,nama_supplier,'.$id.',id_supplier'
        ],[
            'nama_supplier.required' => 'Supplier harus diisi!',
            'nama_supplier.unique' => 'Supplier itu sudah ada!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier gagal ditambahkan!',
                'data' => [
                    'nama_supplier' => $validator->errors()->first('nama_supplier')
                ]
            ], 422);
        }

        $model = Supplier::find($id);
        $model->nama_supplier = $request->input('nama_supplier');
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil diubah!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Supplier gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusSupplier($id){

        $model = Supplier::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil dihapus!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Supplier gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }

  
}