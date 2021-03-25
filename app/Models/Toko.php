<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    protected $fillable = [
        'nama_toko', 'alamat_toko', 'telepon_toko', 'email_toko', 'logo_toko'
    ];

    

}
