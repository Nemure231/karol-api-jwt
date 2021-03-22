<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Merek;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\KodeBarang;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
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

    public function ambilBarang(){

        $data = Barang::join('kategori', 'barang.kategori_id', '=', 'kategori.id_kategori')
                ->join('satuan', 'barang.satuan_id', '=' ,'satuan.id_satuan')
                ->join('merek', 'barang.merek_id', '=', 'merek.id_merek')
                ->join('supplier', 'barang.supplier_id', '=', 'supplier.id_supplier')
                ->select('id_barang', 'harga_pokok','nama_barang', 'nama_supplier', 
                'supplier_id', 'nama_kategori', 'kode_barang', 'stok_barang', 'barang.updated_at as updated_at', 
                'barang.created_at as created_at','nama_merek', 'nama_satuan', 'kategori_id', 'satuan_id',
                'merek_id', 'harga_anggota', 'harga_konsumen')
                ->get();

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
            ], 200);
        }
    }


    public function tambahBarang(Request $request){

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|unique:barang,nama_barang',
            // 'kode_barang' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'merek_id' => 'required',
            'supplier_id' => 'required',
            'harga_pokok' => 'required|numeric',
            'harga_konsumen' => 'required|numeric',
            'harga_anggota' => 'required|numeric',
            'stok_barang' => 'required|numeric',

        ],[
            'nama_barang.required' => 'Barang harus diisi!',
            'nama_barang.unique' => 'Barang itu sudah ada!',
            'kategori_id.required' => 'Kategori harus dipilih!',
            'satuan_id.required' => 'Satuan harus dipilih!',
            'merek_id.required' => 'Merek harus dipilih!',
            'supplier_id.required' => 'Supplier harus dipilih!',
            'harga_pokok.required' => 'Harga pokok harus diisi!',
            'harga_pokok.numeric' => 'Harga pokok harus angka!',
            'harga_konsumen.required' => 'Harga konsumen harus diisi!',
            'harga_konsumen.numeric' => 'Harga konsumen harus angka!',
            'harga_anggota.required' => 'Harga anggota harus diisi!',
            'harga_anggota.numeric' => 'Harga anggota harus angka!',
            'stok_barang.required' => 'Stok harus diisi!',
            'stok_barang.numeric' => 'Stok harus angka!'

        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }

        $kategori_id = $request->kategori_id;
        if (is_numeric($kategori_id)){
            $id_kategori = $kategori_id;
        }else{
            $id_kategori = Kategori::insertGetId([
                'nama_kategori' => $kategori_id, 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $satuan_id = $request->satuan_id;
        if (is_numeric($satuan_id)){
            $id_satuan = $satuan_id;
        }else{
            $id_satuan = Satuan::insertGetId([
                'nama_satuan' => $satuan_id, 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $merek_id = $request->merek_id;
        if (is_numeric($merek_id)){
            $id_merek = $merek_id;
        }else{
            $id_merek = Merek::insertGetId([
                'nama_merek' => $merek_id, 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        $supplier_id = $request->supplier_id;
        if (is_numeric($supplier_id)){
            $id_supplier = $supplier_id;
        }else{
            $id_supplier = Supplier::insertGetId([
                'nama_supplier' => $supplier_id, 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s')
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
        $model->nama_barang = $request->nama_barang;
        $model->kategori_id = $id_kategori;
        $model->satuan_id = $id_satuan;
        $model->merek_id = $id_merek;
        $model->supplier_id = $id_supplier;
        $model->harga_pokok = $request->harga_pokok;
        $model->harga_konsumen = $request->harga_konsumen;
        $model->harga_anggota = $request->harga_anggota;
        $model->stok_barang = $request->stok_barang;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil ditambahkan!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Barang gagal ditambahkan!',
                'data' => '',
            ], 400);
        }
    }

    public function ubahBarang(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|unique:barang,nama_barang,'.$id.',id_barang',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'merek_id' => 'required',
            'supplier_id' => 'required',
            'harga_pokok' => 'required|numeric',
            'harga_konsumen' => 'required|numeric',
            'harga_anggota' => 'required|numeric',
            'stok_barang' => 'required|numeric',

        ],[
            'nama_barang.required' => 'Barang harus diisi!',
            'nama_barang.unique' => 'Barang itu sudah ada!',
            'kategori_id.required' => 'Kategori harus dipilih!',
            'satuan_id.required' => 'Satuan harus dipilih!',
            'merek_id.required' => 'Merek harus dipilih!',
            'supplier_id.required' => 'Supplier harus dipilih!',
            'harga_pokok.required' => 'Harga pokok harus diisi!',
            'harga_pokok.numeric' => 'Harga pokok harus angka!',
            'harga_konsumen.required' => 'Harga konsumen harus diisi!',
            'harga_konsumen.numeric' => 'Harga konsumen harus angka!',
            'harga_anggota.required' => 'Harga anggota harus diisi!',
            'harga_anggota.numeric' => 'Harga anggota harus angka!',
            'stok_barang.required' => 'Stok harus diisi!',
            'stok_barang.numeric' => 'Stok harus angka!'

        ]);


        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()->all()], 422);
        }

        $kategori_id = $request->kategori_id;
        if (is_numeric($kategori_id)){
            $id_kategori = $kategori_id;
        }else{
            $id_kategori = Kategori::insertGetId(['nama_kategori' => $kategori_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $satuan_id = $request->satuan_id;
        if (is_numeric($satuan_id)){
            $id_satuan = $satuan_id;
        }else{
            $id_satuan = Satuan::insertGetId(['nama_satuan' => $satuan_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $merek_id = $request->merek_id;
        if (is_numeric($merek_id)){
            $id_merek = $merek_id;
        }else{
            $id_merek = Merek::insertGetId(['nama_merek' => $merek_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }

        $supplier_id = $request->supplier_id;
        if (is_numeric($supplier_id)){
            $id_supplier = $supplier_id;
        }else{
            $id_supplier = Supplier::insertGetId(['nama_supplier' => $supplier_id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }


        $model = Barang::find($id);
        $model->nama_barang = $request->nama_barang;
        $model->kategori_id = $id_kategori;
        $model->satuan_id = $id_satuan;
        $model->merek_id = $id_merek;
        $model->supplier_id = $id_supplier;
        $model->harga_pokok = $request->harga_pokok;
        $model->harga_konsumen = $request->harga_konsumen;
        $model->harga_anggota = $request->harga_anggota;
        $model->stok_barang = $request->stok_barang;
        $model->save();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil diubah!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Barang gagal diubah!',
                'data' => '',
            ], 400);
        }

    }

    public function hapusBarang($id){

        $model = Barang::find($id);
        $model->delete();

        if($model){
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil dihapus!',
                'data' => ''
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Barang gagal dihapus!',
                'data' => '',
            ], 400);
        }

    }





  
}