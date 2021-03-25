<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'nama_barang', 'kode_barang', 'kategori_id', 'satuan_id', 'merek_id', 
        'supplier_id', 'harga_pokok', 'harga_konsumen', 'harga_anggota', 'stok_barang'
    ];

}
