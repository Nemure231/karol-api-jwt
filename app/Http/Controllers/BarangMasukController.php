<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Merek;
use App\Models\Kategori;
use App\Models\KodeBarang;
use App\Models\Supplier;
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



    public function ambilHargaUntukBarangMasuk($id){
        // $id =  $request->input('id_barang');

        $data = Barang::select('harga_pokok', 'harga_anggota', 'harga_konsumen')->where('id_barang', $id)->first();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Barang barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if($data){
            return response()->json([
                    'success' => false,
                    'message' => 'Barang gagal ditemukan!',
                    'data' => ''
            ], 404);
        }
    }


    public function ambilDetailBarangDanSupplier(){

        $barang = Barang::select('nama_barang', 'id_barang')->get();
        $supplier = Supplier::select('id_supplier', 'nama_supplier')->get();

        if($barang || $supplier){
            return response()->json([
                    'success' => true,
                    'message' => 'Barang barhasil ditemukan!',
                    'data' => [
                        'barang' => $barang,
                        'supplier' => $supplier
                    ]
            ], 200);
        }

        if(!$barang || !$supplier){
            return response()->json([
                    'success' => false,
                    'message' => 'Barang gagal ditemukan!',
                    'data' => ''
            ], 404);
        }


    }

      //////////////////////////////////BARANG MASUK/////////////////////////////////

      public function ambilBarangUntukBarangMasuk(){
        $data = Barang::select('id_barang', 'nama_barang')->get();

        if($data){
            return response()->json([
                    'success' => true,
                    'message' => 'Barang barhasil ditemukan!',
                    'data' => $data
            ], 200);
        }

        if(!$data){
            return response()->json([
                    'success' => false,
                    'message' => 'Barang gagal ditemukan!',
                    'data' => ''
            ], 404);
        }
    }

    public function tambahBarangUntukBarangMasuk(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|unique:barang,nama_barang',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'merek_id' => 'required'

        ],[
            'nama_barang.required' => 'Harus diisi!',
            'nama_barang.unique' => 'Barang itu sudah ada!',
            'kategori_id.required' => 'Harus dipilih!',
            'satuan_id.required' => 'Harus dipilih!',
            'merek_id.required' => 'Harus dipilih!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Barang gagal ditambahkan!',
                'data' => [
                    'nama_barang' => $validator->errors()->first('nama_barang'),
                    'kategori_id' => $validator->errors()->first('kategori_id'),
                    'satuan_id' => $validator->errors()->first('satuan_id'),
                    'merek_id' => $validator->errors()->first('merek_id'),
                ]
            ], 422);
        }

        

        $kategori_id = $request->input('kategori_id');
        if (is_numeric($kategori_id)){
            $id_kategori = $kategori_id;
        }else{
            $id_kategori = Kategori::insertGetId([
                'nama_kategori' => $kategori_id, 
            
            ]);
        }

        $satuan_id = $request->input('satuan_id');
        if (is_numeric($satuan_id)){
            $id_satuan = $satuan_id;
        }else{
            $id_satuan = Satuan::insertGetId([
                'nama_satuan' => $satuan_id, 
            
            ]);
        }

        $merek_id = $request->input('merek_id');
        if (is_numeric($merek_id)){
            $id_merek = $merek_id;
        }else{
            $id_merek = Merek::insertGetId([
                'nama_merek' => $merek_id, 
            ]);
        }

        $kode1 = KodeBarang::select('huruf_kode_barang', 'jumlah_kode_barang')
                    ->first();
        $jumlah_nol_kode = $kode1['jumlah_kode_barang'];

        $query = Barang::select('kode_barang')
                    ->orderBy('kode_barang', 'desc')    
                    ->limit(1)->first();

        $q = $query['kode_barang'];
        $qode[] = substr($q, -$jumlah_nol_kode);
        
            if (count($qode) != 0) {
                $kode= intval($qode[0]) + 1;
            }else{
                $kode =1;
            }
    
        $batas= str_pad($kode, "".$jumlah_nol_kode."","0", STR_PAD_LEFT);
        $kode_auto = "".$kode1['huruf_kode_barang']."".$batas;


        $model = new Barang;
        $model->kode_barang = $kode_auto;
        $model->nama_barang = $request->input('nama_barang');
        $model->kategori_id = $id_kategori;
        $model->satuan_id = $id_satuan;
        $model->merek_id = $id_merek;
        $model->supplier_id = 0;
        $model->harga_pokok = 0;
        $model->harga_konsumen = 0;
        $model->harga_anggota = 0;
        $model->stok_barang = 0;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }
        if(!$model){
            return response()->json([
                'success' => false,
                'message' => 'Barang gagal ditambahkan!',
                'data' => '',
            ], 400);
        }
    }

}