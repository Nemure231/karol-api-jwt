<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const CREATED_AT = 'tanggal';
    const UPDATED_AT =  NULL;

    protected $table = 'barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    protected $fillable = [
        'barang_id', 'supplier_id', 'kuantitas', 'harga_pokok', 'total_harga_pokok'
    ];

    

}
