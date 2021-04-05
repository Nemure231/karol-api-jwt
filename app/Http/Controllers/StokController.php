<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
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

    public function cariStok($min_stok){

        $data =  Barang::select('nama_barang', 'stok_barang', 'kode_barang')
                    ->where('stok_barang', '<=', $min_stok)
                    ->get();
        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Stok barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Stok gagal ditemukan!',
                    'data' => ''
            ], 404);
        }


    }

  
}