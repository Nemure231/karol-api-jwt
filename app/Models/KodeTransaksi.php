<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeTransaksi extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'kode_transaksi';
    protected $primaryKey = 'id_kode_transaksi';
    protected $fillable = [
        'nama_kode_transaksi', 'jumlah_kode_transaksi'
    ];

    public $timestamps = false;

    

}
