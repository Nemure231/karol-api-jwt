<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBarang extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'kode_barang';
    protected $primaryKey = 'id_kode_barang';
    protected $fillable = [
        'nama_kode_barang', 'jumlah_kode_barang'
    ];

    

}
